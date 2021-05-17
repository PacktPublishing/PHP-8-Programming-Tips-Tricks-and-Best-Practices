<?php
// /repo/ch07/php8_zip_oop.php

$fn  = __DIR__ . '/includes/test.zip';
$obj = new ZipArchive();
$res = $obj->open($fn);
$cnt = 0;
if ($res !== TRUE) exit('Unable to open zip file');
for ($i = 0; $entry = $obj->statIndex($i); $i++) {
    echo $entry['name'] . "\n";
}
// NOTE: in PHP 8 you can also use "$obj->count()"
echo "Total Entries: $i\n";
