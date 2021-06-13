<?php
// /repo/src/Migration/OopBreakScan.php
declare(strict_types=1);
namespace Migration;
use ArrayIterator;
/**
 * Designed to run on PHP 7 or below
 * Looks for things that might break OOP code
 */
class OopBreakScan extends Base
{
    /**
     * Searches for __autoload() function (remove in PHP 8)
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanMagicAutoloadFunction(string $contents, array &$message) : bool
    {
        // look for __autoload()
        $found  = 0;
        $found += (stripos($contents, 'function __autoload(') !== FALSE);
        $message[] = ($found)
                   ? Base::ERR_MAGIC_AUTOLOAD
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Looks for usage involving SplFileObject::fgetss()
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanSplFileObjectFgetss(string $contents, array &$message) : bool
    {
        $found  = 0;
        $name   = self::getClassName($contents);
        if ($name) {
            $found += (stripos($contents, 'SplFileObject') !== FALSE);
            $found += (stripos($contents, 'fgetss()') !== FALSE);
        }
        $message[] = ($found === 2)
                   ? Base::ERR_SPL_FGETSS
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Case insensitive search for methods the same name as the class
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanClassnameConstructor(string $contents, array &$message) : bool
    {
        $found  = 0;
        $name   = self::getClassName($contents);
        if ($name) {
            $found += (stripos($contents, 'function ' . $name . '(') !== FALSE);
            $found += (stripos($contents, 'function ' . $name . ' (') !== FALSE);
            $found -= (stripos($contents, 'function __construct') !== FALSE);
        }
        $message[] = ($found)
                   ? Base::ERR_CLASS_CONSTRUCT
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Looks for "die()" or "exit()" in __construct() + __destruct()
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanConstructorExit(string $contents, array &$message) : bool
    {
        $found    = 0;
        $possible = 2;
        $name     = self::getClassName($contents);
        if ($name) {
            $found += (strpos($contents, 'function __destruct') !== FALSE);
            $found += (strpos($contents, 'exit(') !== FALSE);
            $found += (strpos($contents, 'die(') !== FALSE);
        }
        $message[] = ($found >= $possible)
                   ? Base::ERR_CONST_EXIT
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Scan for magic method signatures
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
                        $message[] = Base::ERR_MAGIC_SIGNATURE . $list[$name];
                        $found++;
                    }
                    // check 2nd arg (if any)
                    if (strpos($confirm, ', array')
                        && strpos($line, ', $') === FALSE
                        && strpos($line, ', array') !== FALSE) {
                        $message[] = Base::ERR_MAGIC_SIGNATURE . $list[$name];
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
                            $message[] = Base::ERR_MAGIC_SIGNATURE . $list[$name];
                            $found++;
                        }
                    }
                }
            }
            $iter->next();
        }
        if (!$found) $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Looks for __sleep()
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanMagicSleep(string $contents, array &$message) : bool
    {
        $found    = 0;
        $possible = 2;
        $name     = self::getClassName($contents);
        if ($name) {
            $found += (strpos($contents, 'function __sleep') !== FALSE);
        }
        $message[] = ($found >= $possible)
                   ? Base::ERR_MAGIC_SLEEP
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Looks for any functions named "match"
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanKeywordMatch(string $contents, array &$message) : bool
    {
        $found    = 0;
        $possible = 2;
        $name     = self::getClassName($contents);
        if ($name) {
            $found += (preg_match('/function\s+match(\s)?\(/', $contents) !== FALSE);
        }
        $message[] = ($found >= $possible)
                   ? Base::ERR_MATCH_KEYWORD
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Looks for php_errormsg
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public static function scanPhpErrorMsg(string $contents, array &$message) : bool
    {
        $found    = 0;
        $possible = 2;
        $name     = self::getClassName($contents);
        if ($name) {
            $found += (strpos($contents, 'php_errormsg') !== FALSE);
        }
        $message[] = ($found >= $possible)
                   ? Base::ERR_PHP_ERRORMSG
                   : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
}
