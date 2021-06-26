<?php
// /repo/ch05/php8_oop_diff_static.php
// works in PHP 7 but not PHP 8

class Test {
    public function notStatic()
    {
        return __CLASS__ . PHP_EOL;
    }
}
try {
    echo Test::notStatic();
} catch (Throwable $t) {
    echo $t;
}
echo "\n";

