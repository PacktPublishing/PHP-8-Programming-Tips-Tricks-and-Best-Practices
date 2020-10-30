<?php
namespace Php8\Exits;

/**
 * __construct() throws Exception
 *
 */
use Exception;
class ConstExcept
{
    public function __construct()
    {
        throw new Exception(__METHOD__ . "\n");
    }
    public function __destruct()
    {
        echo __METHOD__ . "\n";
    }
}
