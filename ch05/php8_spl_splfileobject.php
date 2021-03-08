<?php
// /repo/ch05/php8_spl_splfileobject.php
$fn = $_GET['fn'] ?? '';
if (!$fn || !file_exists($fn)) {
    $base  = basename(__FILE__);
    $usage = '<b style="color:red;">Unable to lcocate file</b><br />'
           . 'Need to identify the file as follows:<br />'
           . "/ch05/{$base}?fn=FILENAME\n";
    exit($usage);
}
$obj = new SplFileObject($fn, 'r');
$safe = '';
while ($line = $obj->fgets()) {
    $safe .= strip_tags($line);
}
echo '<h1>Contents</h1><hr>' . $safe;
