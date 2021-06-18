<?php
// /repo/src/Migration/OopBreakScan.php
declare(strict_types=1);
namespace Migration;
use Exception;
use ArrayIterator;
/**
 * Designed to run on PHP 7 or below
 * Looks for things that might break OOP code
 */
class OopBreakScan
{
    const ERR_MAGIC_SIGNATURE = 'WARNING: need to confirm magic method signature: ';
    const ERR_NAMESPACE       = 'WARNING: namespaces can no longer contain spaces in PHP 8.';
    const ERR_REMOVED         = 'WARNING: the following function has been removed: %s.  Use this instead: %s';
    const ERR_MISSING_KEY     = 'ERROR: missing configuration key %s';
    const WARN_BC_BREAKS      = 'WARNING: the code in this file might not be compatible with PHP 8';
    const NO_BC_BREAKS        = 'SUCCESS: the code scanned in this file is potentially compatible with PHP 8';
    const OK_PASSED = 'PASSED this scan: %s';
    public $config = [];
    /**
     * @param array $config : scan config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    /**
     * Runs all scans
     *
     * @param string $contents : contents of file to be searched
     * @param array $message   : return success or failure message
     * @return int $found : number of potential BC breaks found
     */
    public function runAllScans(string $contents, array &$messages) : int
    {
        $found = 0;
        $found += $this->scanRemovedFunctions($contents, $messages);
        $found += $this->scanSpacesInNamespace($contents, $messages);
        $found += $this->scanMagicSignatures($contents, $messages);
        $found += $this->scanFromConfig($contents, $messages);
        return $found;
    }
    /**
     * Check for removed functions
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return int $found      : number of BC breaks detected
     */
    public function scanRemovedFunctions(string $contents, array &$message) : int
    {
        $found = 0;
        $config = $this->config['removed'] ?? NULL;
        if (empty($config)) {
            $message = sprintf(self::ERR_MISSING_KEY, 'removed');
            throw new Exception($message);
        }
        $list = array_keys($config);
        foreach ($config as $func => $replace) {
            if ((strpos($contents, $func) !== FALSE)) {
                $message[] = sprintf(self::ERR_REMOVED, $func, $replace);
                $found++;
            }
        }
        if ($found === 0)
            $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return $found;
    }
    /**
     * Scan for spaces in namespace references
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return int $found      : number of BC breaks detected
     */
    public function scanSpacesInNamespace(string $contents, array &$message) : int
    {
        if ($pos = stripos($contents, 'namespace') !== FALSE) {
            $pos += 9;  // offset for "namespace"
            $end = strpos($contents, ';', $pos);
            $test = trim(substr($contents, $pos, $end - $pos));
            if ((strpos($test, ' ') !== FALSE)) {
                $message[] = self::ERR_NAMESPACE;
                return 1;
            }
        }
        $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return 0;
    }
    /**
     * Scan for magic method signatures
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return int $found      : number of BC breaks detected
     */
    public function scanMagicSignatures(string $contents, array &$message) : int
    {
        // bail out if no magic methods defined
        if (strpos($contents, 'function __') === FALSE) return 0;
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
        if ($found === 0) $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return $found;
    }
    /**
     * Gets the class name
     *
     * @param string $contents : PHP file contents
     * @return string $name    : classname
     */
    public function getClassName(string $contents) : string
    {
        preg_match('/class (.+?)\b/', $contents, $matches);
        return $matches[1] ?? '';
    }
    /**
     * Runs a single scan key (defined in bc_break_scanner.config.php)
     * NOTE: $messages is passed by reference
     *
     * @param string $key : key defined in bc_break_scanner.config.php
     * @param string $class : class name of this file
     * @param string $contents : contents of file to be searched
     * @return int $found : number of potential BC breaks found
     */
    public function runScanKey(string $key, string $class, string $contents, array &$messages)
    {
        $config = $this->config['scans'][$key] ?? [];
        if (empty($config)) {
            $message = sprintf(self::ERR_MISSING_KEY, 'scans => ' . $key);
            throw new UnexpectedValueException($message);
        }
        if (!isset($config['callback'])) return 0;
        $result = $config['callback']($class, $contents);
        if ($result) {
            $messages[] = $config['msg'];
        }
        return (int) $result;
    }
    /**
     * Runs all scans key as defined in $this->config (bc_break_scanner.config.php)
     * NOTE: $messages is passed by reference
     *
     * @param string $contents : contents of file to be searched
     * @return int $found : number of potential BC breaks found
     */
    public function scanFromConfig(string $contents, array &$messages)
    {
        $found = 0;
        $class = $this->getClassName($contents);
        $config = $this->config['scans'] ?? NULL;
        if (empty($config)) {
            $message = sprintf(self::ERR_MISSING_KEY, 'scans');
            throw new Exception($message);
        }
        $list = array_keys($config);
        foreach ($list as $key) {
            $found += $this->runScanKey($key, $class, $contents, $messages);
        }
        return $found;
    }
}
