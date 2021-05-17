<?php
// /repo/ch07/php7_zip_functions.php

$fn  = __DIR__ . '/includes/test.zip';
$zip = zip_open($fn);
$cnt = 0;
if (!is_resource($zip)) exit('Unable to open zip file');
while ($entry = zip_read($zip)) {
    echo zip_entry_name($entry) . "\n";
    $cnt++;
}
echo "Total Entries: $cnt\n";
