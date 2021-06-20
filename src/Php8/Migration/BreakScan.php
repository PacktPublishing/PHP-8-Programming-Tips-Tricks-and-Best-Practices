<?php
// /repo/src/Php8/Migration/BreakScan.php
declare(strict_types=1);
namespace Php8\Migration;
use InvalidArgumentException;
use UnexpectedValueException;
/**
 * Looks for things that might your code after a PHP 8 migration
 *
 * @todo: add line number of potential break (use file($fn) instead of file_get_contents($fn))
 * @author: doug@unlikelysource.com
 */
class BreakScan
{
    const ERR_MAGIC_SIGNATURE = 'WARNING: magic method signature for %s does not appear to match required signature';
    const ERR_REMOVED         = 'WARNING: the following function has been removed: %s.  Use this instead: %s';
    const ERR_IS_RESOURCE     = 'WARNING: this function no longer produces a resource: %s.  Usage of "is_resource($item)" should be replaced with "!empty($item)';
    const ERR_MISSING_KEY     = 'ERROR: missing configuration key %s';
    const ERR_INVALID_KEY     = 'ERROR: this configuration key is either missing or not callable: ';
    const ERR_FILE_NOT_FOUND  = 'ERROR: file not found: %s';
    const WARN_BC_BREAKS      = 'WARNING: the code in this file might not be compatible with PHP 8';
    const NO_BC_BREAKS        = 'SUCCESS: the code scanned in this file is potentially compatible with PHP 8';
    const OK_PASSED           = 'PASSED this scan: %s';
    const TOTAL_BREAKS        = 'Total potential BC breaks: %d' . PHP_EOL;
    const KEY_REMOVED         = 'removed';
    const KEY_CALLBACK        = 'callbacks';
    const KEY_MAGIC           = 'magic';
    const KEY_RESOURCE        = 'resource';

    public $config = [];
    public $contents = '';
    public $messages = [];
    /**
     * @param array $config : scan config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $required = [self::KEY_CALLBACK, self::KEY_REMOVED, self::KEY_MAGIC, self::KEY_RESOURCE];
        foreach ($required as $key) {
            if (!isset($this->config[$key])) {
                $message = sprintf(self::ERR_MISSING_KEY, $key);
                throw new InvalidArgumentException($message);
            }
        }
    }
    /**
     * Grabs contents
     * Initializes messages to []
     * Converts "\r" and "\n" to ' '
     *
     * @param string $fn    : name of file to scan
     * @return string $name : classname
     */
    public function getFileContents(string $fn) : string
    {
        if (!file_exists($fn)) {
            $this->contents  = '';
            throw new InvalidArgumentException(sprintf(self::ERR_FILE_NOT_FOUND, $fn));
        }
        $this->contents = file_get_contents($fn);
        $this->contents = str_replace(["\r","\n"],['', ' '], $this->contents);
        return $this->contents;
    }
    /**
     * Extracts the value immediately following the supplied word up until the supplied end
     *
     * @param string $contents : text to search (usually $this->contents)
     * @param string $key   : starting keyword or set of characters
     * @param string $end   : ending delimiter
     * @return string $name : classname
     */
    public static function getKeyValue(string $contents, string $key, string $end)
    {
        $pos = strpos($contents, $key);
        $end = strpos($contents, $end, $pos + strlen($key) + 1);
        return trim(substr($contents, $pos + strlen($key), $end - $pos - strlen($key)));
    }
    /**
     * Clears messages
     *
     * @return void
     */
    public function clearMessages() : void
    {
        $this->messages = [];
    }
    /**
     * Returns messages
     *
     * @param bool $clear      : If TRUE, reset messages to []
     * @return array $messages : accumulated messages
     */
    public function getMessages(bool $clear = FALSE) : array
    {
        $messages = $this->messages;
        if ($clear) $this->clearMessages();
        return $messages;
    }
    /**
     * Runs all scans
     *
     * @return int $found : number of potential BC breaks found
     */
    public function runAllScans() : int
    {
        $found = 0;
        $found += $this->scanRemovedFunctions();
        $found += $this->scanIsResource();
        $found += $this->scanMagicSignatures();
        $found += $this->scanFromCallbacks();
        return $found;
    }
    /**
     * Check for removed functions
     *
     * @return int $found : number of BC breaks detected
     */
    public function scanRemovedFunctions() : int
    {
        $found = 0;
        $config = $this->config[self::KEY_REMOVED] ?? NULL;
        // we add this extra safety check in case this method is called separately
        if (empty($config)) {
            $message = sprintf(self::ERR_MISSING_KEY, self::KEY_REMOVED);
            throw new Exception($message);
        }
        foreach ($config as $func => $replace) {
            $search1 = ' ' . $func . '(';
            $search2 = ' ' . $func . ' (';
            if (strpos($this->contents, $search1) !== FALSE
                || strpos($this->contents, $search2) !== FALSE) {
                $this->messages[] = sprintf(self::ERR_REMOVED, $func, $replace);
                $found++;
            }
        }
        if ($found === 0)
            $this->messages[] = sprintf(self::OK_PASSED, __FUNCTION__);
        return $found;
    }
    /**
     * Check for is_resource usage
     * If "is_resource" found, check against list of functions
     * that no longer produce resources in PHP 8
     *
     * @return int $found : number of BC breaks detected
     */
    public function scanIsResource() : int
    {
        $found = 0;
        $search = 'is_resource';
        // if "is_resource" not found discontinue search
        if (strpos($this->contents, $search) === FALSE) return 0;
        // pull list of functions that now return objects instead of resources
        $config = $this->config[self::KEY_RESOURCE] ?? NULL;
        // we add this extra safety check in case this method is called separately
        if (empty($config)) {
            $message = sprintf(self::ERR_MISSING_KEY, self::KEY_RESOURCE);
            throw new Exception($message);
        }
        foreach ($config as $func) {
            if ((strpos($this->contents, $func) !== FALSE)) {
                $this->messages[] = sprintf(self::ERR_IS_RESOURCE, $func);
                $found++;
            }
        }
        if ($found === 0)
            $this->messages[] = sprintf(self::OK_PASSED, __FUNCTION__);
        return $found;
    }
    /**
     * Scan for magic method signatures
     *
     * @return int $found : number of BC breaks detected
     */
    public function scanMagicSignatures() : int
    {
        // locate all magic methods
        $found   = 0;
        $matches = [];
        $result  = preg_match_all('/function __(.+?)\b/', $this->contents, $matches);
        if (!empty($matches[1])) {
            $config = $this->config[self::KEY_MAGIC] ?? NULL;
            // we add this extra safety check in case this method is called separately
            if (empty($config)) {
                $message = sprintf(self::ERR_MISSING_KEY, self::KEY_MAGIC);
                throw new Exception($message);
            }
            foreach ($matches[1] as $name) {
                $key = '__' . $name;
                // skip if key not found.  must not be a defined magic method
                if (empty($config[$key])) continue;
                if ($pos = strpos($this->contents, $key)) {
                    // extract the substring
                    $end = strpos($this->contents, '{', $pos);
                    $sub = trim(substr($this->contents, $pos, $end - $pos));
                    // pull up the regex
                    $ptn = $config[$key]['regex'] ?? '/.*/';
                    // test for a match
                    if (!preg_match($ptn, $sub)) {
                        $this->messages[] = sprintf(self::ERR_MAGIC_SIGNATURE, $key);
                        $this->messages[] = $config[$key]['signature'] ?? 'Check signature';
                        $found++;
                    }
                }
            }
        }
        if ($found === 0)
            $this->messages[] = sprintf(self::OK_PASSED, __FUNCTION__);
        return $found;
    }
    /**
     * Makes sure callback key exists and is callable
     *
     * @param string $key : key defined in bc_break_scanner.config.php::callbacks
     * @return array $config|NULL : If everything is OK returns the config for that key; otherwise an exception is thrown
     * @throws InvalidArgumentException | UnexpectedValueException
     */
    protected function validateCallbackKey(string $key) : ?array
    {
        $config = $this->config[self::KEY_CALLBACK][$key] ?? NULL;
        if (empty($config)) {
            $message = sprintf(self::ERR_MISSING_KEY, self::KEY_CALLBACK . ' => ' . $key);
            throw new InvalidArgumentException($message);
        } elseif (empty($config['callback']) || !is_callable($config['callback'])) {
            $message = sprintf(self::ERR_INVALID_KEY, self::KEY_CALLBACK . ' => ' . $key . ' => callback');
            throw new InvalidArgumentException($message);
        }
        return $config;
    }
    /**
     * Runs a single callback key (defined in bc_break_scanner.config.php)
     *
     * @param string $key : key defined in bc_break_scanner.config.php::callbacks
     * @return int $found : number of potential BC breaks found
     * @throws UnexpectedValueException
     */
    public function runCallbackByKey(string $key) : int
    {
        // validate the callback key
        $config = $this->validateCallbackKey($key);
        // run the callback
        $found = $config['callback']($this->contents);
        if ($found) {
            $this->messages[] = $config['msg'];
        }
        return (int) $found;
    }
    /**
     * Runs all scans key as defined in $this->config (bc_break_scanner.config.php)
     *
     * @return int $found : number of potential BC breaks found
     */
    public function scanFromCallbacks()
    {
        $found = 0;
        $list = array_keys($this->config[self::KEY_CALLBACK]);
        foreach ($list as $key) {
            $found += $this->runCallbackByKey($key);
        }
        return $found;
    }
}
