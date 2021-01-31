<?php
// /repo/src/Migration/OopBreakScan.php
declare(strict_types=1);
namespace Migration;
/**
 * Designed to run on PHP 7 or below
 * Looks for things that might break OOP code
 */
class OopBreakScan
{
    const ERR_CLASS_CONSTRUCT = 'WARNING: contains method same name as class but no __construct() method defined';
    const ERR_CONST_EXIT      = 'WARNING: __destruct() might not get called if "die()" or "exit()" used in __construct()';
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
        return $found;
    }
}
