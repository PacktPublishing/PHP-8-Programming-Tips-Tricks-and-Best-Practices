<?php
// /repo/ch09/php8_bc_break_magic.php
declare(strict_types=1);
class NoTypes
{
    public function __call($name, $args)
    {
        return "Attempt made to call '$name' "
            . "with these arguments: '"
            . implode(',', $args) . "'\n";
    }
}
$no = new NoTypes();
echo $no->doesNotExist('A','B','C');

class MixedTypes
{
    public function __invoke(array $args) : string
    {
        return "Arguments: '"
            . implode(',', $args) . "'\n";
    }
}
$mixed= new MixedTypes();
echo $mixed(['A','B','C']);
