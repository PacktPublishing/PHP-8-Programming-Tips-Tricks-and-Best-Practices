<?php
// /repo/ch09/php7_namespace_bad.php
namespace Doesnt \Work \In \PHP8;
class Test
{
    public const TEST = 'TEST';
}
echo Test::TEST . "\n";
