<?php
// /repo/ch08/php7_closure_from_callable.php

require __DIR__ . '/../src/Services/HashGen.php';
use Services\HashGen;
$hashGen = new HashGen();

$doMd5 = $hashGen->makeHash('md5');
$text  = 'The quick brown fox jumped over the fence';
echo $doMd5($text) . "\n";
var_dump($doMd5);

$temp = new class() { public $class = 'Anonymous: '; };
$doMd5->bindTo($temp);
echo $doMd5($text) . "\n";
var_dump($doMd5);

// output:
/*
Warning: Cannot bind method Services\HashGen::hashToMd5() to object of class class@anonymous in /repo/ch08/php7_closure_from_callable.php on line 14
HashGen: b335d9cb00b899bc6513ecdbb2187087
/repo/ch08/php7_closure_from_callable.php:16:
class Closure#2 (2) {
  public $this =>
  class Services\HashGen#1 (1) {
    public $class =>
    string(9) "HashGen: "
  }
  public $parameter =>
  array(1) {
    '$text' =>
    string(10) "<required>"
  }
}
*/
