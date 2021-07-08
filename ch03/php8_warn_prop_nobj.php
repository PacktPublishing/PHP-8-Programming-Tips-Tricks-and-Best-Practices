<?php
// /repo/ch03/php8_warn_prop_nobj.php
$a->test = 0;
$a->test++;
var_dump($a);

// output:
// Fatal error: Uncaught Error: Attempt to assign property "test" on null in /repo/ch03/php8_warn_prop_nobj.php on line 3
