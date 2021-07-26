<?php
namespace Migration;
class OopBreakScan extends Base
{
    public static function scanMagicAutoloadFunction(
        string $contents, array &$message) : bool
    {
        $found = 0;
        $found += (stripos($contents,'function __autoload(') !== FALSE);
        $message[] = ($found)
                    ? Base::ERR_MAGIC_AUTOLOAD
                    : sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
}
