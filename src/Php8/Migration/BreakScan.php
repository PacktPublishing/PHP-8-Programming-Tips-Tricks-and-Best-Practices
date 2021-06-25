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
    const MAGIC_METHODS       = 'The following magic methods were detected:';
    const OK_PASSED           = 'PASSED this scan: %s';
    const TOTAL_BREAKS        = 'Total potential BC breaks: %d' . PHP_EOL;
    const KEY_REMOVED         = 'removed';
    const KEY_CALLBACK        = 'callbacks';
    const KEY_MAGIC           = 'magic';
    const KEY_RESOURCE        = 'resource';

    public $config = [];
    public $contents = '';
    public $messages = [];
    public $magic = [];
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
        $this->clearMessages();
        $this->contents = file_get_contents($fn);
        $this->contents = str_replace(["\r","\n"],['', ' '], $this->contents);
        return $this->contents;
    }
    /**
     * Extracts the value immediately following the supplied word up until the supplied end
     *
     * @param string $contents : text to search (usually $this->contents)
     * @param string $key   : starting keyword or set of characters
     * @param string $delim : ending delimiter
     * @return string $name : classname
     */
    public static function getKeyValue(string $contents, string $key, string $delim)
    {
        $pos = strpos($contents, $key);
        if ($pos === FALSE) return '';
        $end = strpos($contents, $delim, $pos + strlen($key) + 1);
        $key = substr($contents, $pos + strlen($key), $end - $pos - strlen($key));
        if (is_string($key)) {
            $key = trim($key);
        } else {
            $key = '';
        }
        $key = trim($key);
        return $key;
    }
    /**
     * Clears messages
     *
     * @return void
     */
    public function clearMessages() : void
    {
        $this->messages = [];
        $this->magic    = [];
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
     * Returns 0 and adds OK message
     *
     * @param string $function
     * @return int 0
     */
    public function passedOK(string $function) : int
    {
        $this->messages[] = sprintf(self::OK_PASSED, $function);
        return 0;
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
        echo __METHOD__ . ':' . var_export($this->messages, TRUE) . "\n";
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
        return ($found === 0) ? $this->passedOK(__FUNCTION__) : $found;
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
        if (strpos($this->contents, $search) === FALSE) return $this->passedOK(__FUNCTION__);
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
        return ($found === 0) ? $this->passedOK(__FUNCTION__) : $found;
    }
    /**
     * Scan for magic method signatures
     * NOTE: doesn't check inside parentheses.
     *       only checks for return data type + displays found and correct signatures for manual comparison
     *
     * @return int $found : number of invalid return data types
     */
    public function scanMagicSignatures() : int
    {
        // locate all magic methods
        $found   = 0;
        $matches = [];
        $messages = [];
        $magic    = [];
        $result  = preg_match_all('/function __(.+?)\b/', $this->contents, $matches);
        if (!empty($matches[1])) {
            $this->messages[] = self::MAGIC_METHODS;
            $config = $this->config[self::KEY_MAGIC] ?? NULL;
            // we add this extra safety check in case this method is called separately
            if (empty($config)) {
                $message = sprintf(self::ERR_MISSING_KEY, self::KEY_MAGIC);
                throw new Exception($message);
            }
            foreach ($matches[1] as $name) {
                $key = '__' . $name;
                // skip if key not found.  must not be a defined magic method
                if (!isset($config[$key])) continue;
                // record official signature
                $this->messages[] = 'Signature: ' . ($config[$key]['signature'] ?? 'Signature not found');
                $sub = $this->getKeyValue($this->contents, $key, '{');
                if ($sub) {
                    $sub = $key . $sub;
                    // record found signature
                    $this->messages[] = 'Actual   : ' . $sub;
                    // look for return type
                    if (strpos($sub, ':')) {
                        $ptn = '/.*?\(.*?\)\s*:\s*' . $config[$key]['return'] . '/';
                        // test for a match
                        if (!preg_match($ptn, $sub)) {
                            $this->messages[] = sprintf(self::ERR_MAGIC_SIGNATURE, $key);
                            $found++;
                        }
                    }
                }
            }
        }
        //echo __METHOD__ . ':' . var_export($this->messages, TRUE) . "\n";
        return ($found === 0) ? $this->passedOK(__FUNCTION__) : $found;
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
            $config = $this->config[self::KEY_CALLBACK][$key] ?? NULL;
            if (empty($config['callback']) || !is_callable($config['callback'])) {
                $message = sprintf(self::ERR_INVALID_KEY, self::KEY_CALLBACK . ' => ' . $key . ' => callback');
                throw new InvalidArgumentException($message);
            }
            if ($config['callback']($this->contents)) {
                $this->messages[] = $config['msg'];
                $found++;
            }
        }
        return $found;
    }
}
