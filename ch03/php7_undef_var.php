<?php
// /repo/ch03/php7_undef_var.php
$c = $a + $b;
var_dump($c);

// output:
/*
Notice: Undefined variable: a in /repo/ch03/php7_undef_var.php on line 3
Notice: Undefined variable: b in /repo/ch03/php7_undef_var.php on line 3
int(0)
 */
