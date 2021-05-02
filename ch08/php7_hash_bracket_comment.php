<?php
// /repo/ch08/php7_hash_bracket_ comment.php

$test = new class() {
    # This works
    public $works = 'OK';
    #[ This does not work in PHP 8 as a comment]
    public $worksPhp7 = 'OK';
};
var_dump($test);

