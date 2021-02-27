<?php
// /repo/src/Php7/Connector/Base.php
namespace Php7\Connector;
abstract class Base implements ConnectInterface
{
    const CONN_TERMINATED = 'Connection Terminated';
    public $conn = NULL;
    public function __destruct()
    {
        $message = get_class($this)
                 . ':' . self::CONN_TERMINATED;
        error_log($message);
    }
}
