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
    const OK_PASSED = 'PASSED this scan: %s';
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
        $regex1 = '/class (.+?)\b/';
        preg_match($regex1, $contents, $matches);
        if ($matches[1]) {
            $found += (stripos($contents, 'function ' . $matches[1] . '(') !== FALSE);
            $found += (stripos($contents, 'function ' . $matches[1] . ' (') !== FALSE);
            $found -= (stripos($contents, 'function __construct()') !== FALSE);
        }
        $message[] = ($found)
                   ? self::ERR_CLASS_CONSTRUCT
                   : sprintf(self::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
}
