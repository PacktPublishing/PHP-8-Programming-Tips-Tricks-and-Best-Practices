<?php
// /repo/ch09/php8_namespace_reserved.php
namespace List\Works\Only\In\PHP8;
class Test
{
    public const TEST = 'TEST';
}
echo Test::TEST . "\n";
