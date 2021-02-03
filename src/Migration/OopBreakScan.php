<?php
// /repo/src/Migration/OopBreakScan.php
declare(strict_types=1);
namespace Migration;
use ArrayIterator;
/**
 * Designed to run on PHP 7 or below
 * Looks for things that might break OOP code
 */
class OopBreakScan
{
    const ERR_CLASS_CONSTRUCT = 'WARNING: contains method same name as class but no __construct() method defined';
    const ERR_CONST_EXIT      = 'WARNING: __destruct() might not get called if "die()" or "exit()" used in __construct()';
    const ERR_MAGIC_SIGNATURE = 'WARNING: need to confirm magic method signature: ';
    const ERR_MAGIC_SLEEP     = 'WARNING: need to confirm __sleep() return values match properties';
    const OK_PASSED = 'PASSED this scan: %s';
    /**
     *
     * @param string $contents : PHP file contents
     * @return string $name    : classname
     */
    public static function getClassName(string $contents) : string
    {
        preg_match('/class (.+?)\b/', $contents, $matches);
        return $matches[1] ?? '';
    }
    /**
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanClassnameConstructor(string $contents, array &$message) : bool
    {
        // look for classname and method of the same name
        $found  = 0;
        $name   = self::getClassName($contents);
        if ($name) {
            $found += (stripos($contents, 'function ' . $name . '(') !== FALSE);
            $found += (stripos($contents, 'function ' . $name . ' (') !== FALSE);
            $found -= (stripos($contents, 'function __construct') !== FALSE);
        }
        $message[] = ($found)
                   ? self::ERR_CLASS_CONSTRUCT
                   : sprintf(self::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanConstructorExit(string $contents, array &$message) : bool
    {
        // look for "die()" or "exit()" in __construct() + __destruct()
        $found    = 0;
        $possible = 2;
        $name     = self::getClassName($contents);
        if ($name) {
            $found += (strpos($contents, 'function __destruct') !== FALSE);
            $found += (strpos($contents, 'exit(') !== FALSE);
            $found += (strpos($contents, 'die(') !== FALSE);
        }
        $message[] = ($found >= $possible)
                   ? self::ERR_CONST_EXIT
                   : sprintf(self::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanMagicSignatures(string $contents, array &$message) : bool
    {
        // bail out if no magic methods defined
        if (strpos($contents, 'function __') === FALSE) return FALSE;
        // list of signature patterns
        $list = [
            '__call'       => '__call(string $name, array $arguments): mixed',
            '__callStatic' => '__callStatic(string $name, array $arguments): mixed',
            '__clone'      => '__clone(): void',
            '__debugInfo'  => '__debugInfo(): ?array',
            '__get'        => '__get(string $name): mixed',
            '__invoke'     => '__invoke(mixed $arguments): mixed',
            '__isset'      => '__isset(string $name): bool',
            '__serialize'  => '__serialize(): array',
            '__set'        => '__set(string $name, mixed $value): void',
            '__set_state'  => '__set_state(array $properties): object',
            '__sleep'      => '__sleep(): array',
            '__unserialize'=> '__unserialize(array $data): void',
            '__unset'      => '__unset(string $name): void',
            '__wakeup'     => '__wakeup(): void',
        ];
        // break contents into ArrayIterator
        $iter = new ArrayIterator(explode("\n", $contents));
        // go line-by-line
        $found    = 0;
        while ($iter->valid()) {
            $line = $iter->current();
            // skip if not magic method function signature
            if (strpos($contents, 'function __') !== FALSE) {
                // extract method name
                $extract = '/(__\w+?).*?\(/';
                preg_match($extract, $line, $matches);
                $name = $matches[1] ?? 'XXX';
                $name = trim($name);
                // locate signature
                $confirm = $list[$name] ?? '';
                if ($confirm) {
                    // check 1st arg
                    if (strpos($line, '($') === FALSE
                        && strpos($confirm, '(string')
                        &&strpos($line, '(string') === FALSE) {
                        $message[] = self::ERR_MAGIC_SIGNATURE . $list[$name];
                        $found++;
                    }
                    // check 2nd arg (if any)
                    if (strpos($confirm, ', array')
                        && strpos($line, ', $') === FALSE
                        && strpos($line, ', array') !== FALSE) {
                        $message[] = self::ERR_MAGIC_SIGNATURE . $list[$name];
                        $found++;
                    }
                    // check return data type (if any)
                    if (strpos($line, ':') !== FALSE) {
                        // extract return data type from $confirm
                        $pos = strpos($confirm, ':');
                        $type = trim(substr($confirm, $pos));
                        // extract return data type from $line
                        $pos = strpos($line, ':');
                        $check = substr($line, $pos);
                        $check = str_replace('{', '', $check);
                        $check = trim($check);
                        if ($type !== $check) {
                            $message[] = self::ERR_MAGIC_SIGNATURE . $list[$name];
                            $found++;
                        }
                    }
                }
            }
            $iter->next();
        }
        if (!$found) $message[] = sprintf(self::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanMagicSleep(string $contents, array &$message) : bool
    {
        // look for __sleep()
        $found    = 0;
        $possible = 2;
        $name     = self::getClassName($contents);
        if ($name) {
            $found += (strpos($contents, 'function __sleep') !== FALSE);
        }
        $message[] = ($found >= $possible)
                   ? self::ERR_MAGIC_SLEEP
                   : sprintf(self::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
}
