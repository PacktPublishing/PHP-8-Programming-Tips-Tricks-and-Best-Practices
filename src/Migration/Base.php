<?php
namespace Migration;
class Base
{
    const ERR_MAGIC_AUTOLOAD = 'WARNING: the "__autoload()" function is removed in PHP 8: '
                             . 'replace with "spl_autoload_register()"';
    const OK_PASSED = 'Passed %s';
}
