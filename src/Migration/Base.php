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
    const ERR_CLASS_CONSTRUCT = 'WARNING: contains method same name as class but no __construct() method defined';
    const ERR_CONST_EXIT      = 'WARNING: __destruct() might not get called if "die()" or "exit()" used in __construct()';
    const ERR_SPL_FGETSS      = 'WARNING: support for SplFileObject::fgetss() has been removed: use "strip_tags(SplFileObject::fgets())" instead';
    const ERR_MAGIC_SIGNATURE = 'WARNING: need to confirm magic method signature: ';
    const ERR_MAGIC_SLEEP     = 'WARNING: need to confirm __sleep() return values match properties';
    const ERR_MAGIC_AUTOLOAD  = 'WARNING: the "__autoload()" function is removed in PHP 8: replace with "spl_autoload_register()"';
    const OK_PASSED = 'PASSED this scan: %s';
    const WARN_BC_BREAKS      = 'WARNING: the code scanned might not be compatible with PHP 8';
    const NO_BC_BREAKS        = 'SUCCESS: it appears that the code scanned is potentially compatible with PHP 8';
    /**
     * Gets the class name
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
     * Runs all scans on the contents of a single file
     *
     * @param string $fn    : name of file to be scanned
     * @return string $name : classname
     */
    public static function runAllScans(string $fn, array &$messages) : array
    {
        if (!file_exists($fn) && !is_file($fn)) return FALSE;
        $contents = file_get_contents($fn);
        $temp     = [];
        $found    = 0;
        $methods  = get_class_methods(__CLASS__);
        foreach ($methods as $method)
            $found += __CLASS__::$method($contents, $temp);
        $messages[] = 'FILENAME: ' . $fn;
        if ($found) {
            $messages[] = self::WARN_BC_BREAKS;
        } else {
            $messages[] = self::NO_BC_BREAKS);
        }
        array_merge($messages, $temp);
        return $messages;
    }
}
