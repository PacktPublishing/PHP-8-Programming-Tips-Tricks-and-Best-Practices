<?php
// /repo/src/Migration/OopBreakScan.php
declare(strict_types=1);
namespace Migration;
/**
 * Designed to run on PHP 7 or below
 * Looks for things that might break OOP code
 */
class Base
{
    const OK_PASSED = 'PASSED this scan: %s';
    public $config = [];
    public $list = [];   // list of scans to run
    /**
     * @param array $config : scan config
     */
    public function __construct(array $config, array $list = [])
    {
        $this->config = $config;
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
     * Runs all scans on the contents of a single file
     *
     * @param string $fn    : name of file to be scanned
     * @param array $message: messages returned by scan
     * @param array $list   : list of selected scans to run
     * @return string $name : classname
     */
    public function runScans(string $fn, array &$messages, array $list = []) : array
    {
        if (!file_exists($fn) && !is_file($fn)) return FALSE;
        // grab file contents and strip out CR/LF
        $contents = file_get_contents($fn);
        $contents = str_replace(["\r","\n"], ' ', $contents);
        $class    = $this->getClassName($contents);
        $found    = 0;
        $local_msg[] = 'FILENAME: ' . $fn;
        if ($list) {
            $temp = $list;
        } else {
            $temp = array_keys($this->config['scans']);
        }
        foreach ($temp as $key)
            $found += $this->runScanKey($class, $key, $contents, $local_msg);
        if ($found) {
            $messages[] = self::WARN_BC_BREAKS;
        } else {
            $messages[] = self::NO_BC_BREAKS;
        }
        foreach ($local_msg as $msg) $messages[] = $msg;
        return $found;
    }
    /**
     * Runs a single scan key (defined in bc_break_scanner.config.php)
     * NOTE: $messages is passed by reference
     *
     * @param string $class : class name of this file
     * @param string $key : key defined in bc_break_scanner.config.php
     * @param string $contents : contents of file to be searched
     * @return int $found : number of potential BC breaks found
     */
    public function runScanKey(string $class, string $key, string $contents, array &$messages)
    {
        $config = $this->config[$key] ?? [];
        if (empty($config)) return 0;
        if (!isset($config['callback'])) return 0;
        if ($config['callback']($class, $contents)) {
            $message[] = $config['msg'];
        }
        return 1;
    }
}
