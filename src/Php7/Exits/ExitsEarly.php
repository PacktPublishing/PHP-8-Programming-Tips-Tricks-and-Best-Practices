<?php
namespace Php7\Exits;

/**
 * Demonstrates Exiting from __construct()
 *
 */
class ExitsEarly
{
    public function __construct()
    {
        exit(__METHOD__ . "\n");
    }
    public function __destruct()
    {
        echo __METHOD__ . "\n";
    }
}
