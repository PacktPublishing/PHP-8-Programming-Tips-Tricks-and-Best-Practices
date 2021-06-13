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
    const ERR_MAGIC_SIGNATURE = 'WARNING: need to confirm magic method signature: ',
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
}
