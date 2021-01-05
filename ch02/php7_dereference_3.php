<?php
// /repo/ch02/php7_dereference_3.php
define('FILENAME', __FILE__);

echo FILENAME[-3] . FILENAME[-2] . FILENAME[-1];
echo "\n";
echo __FILE__[-3] . __FILE__[-2] . __FILE__[-1];
// output:
/*
PHP Parse error:  syntax error, unexpected '[', expecting ';' or ',' in php7_dereference_3.php on line 7
Parse error: syntax error, unexpected '[', expecting ';' or ',' in php7_dereference_3.php on line 7
*/
