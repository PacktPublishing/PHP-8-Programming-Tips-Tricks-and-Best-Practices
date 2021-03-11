<?php
// /repo/ch05/php8_oop_diff_static.php

class Test {
    public function notStatic()
    {
        return __CLASS__ . PHP_EOL;
    }
}
echo Test::notStatic();
