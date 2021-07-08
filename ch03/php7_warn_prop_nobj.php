<?php
// /repo/ch03/php7_warn_prop_nobj.php

$a->test = 0;
$a->test++;
var_dump($a);

// output:
/*
Warning: Creating default object from empty value in /repo/ch03/php7_warn_prop_nobj.php on line 4
class stdClass#1 (1) {
  public $test =>
  int(1)
}
 */
