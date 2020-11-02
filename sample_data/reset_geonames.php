<?php
// /repo/ch02/php7_str_contains.php
// removes "alternatenames" field
// first run this from the command line:
/*
# wget https://download.geonames.org/export/dump/cities15000.zip
# unzip cities15000.zip
# rm cities15000.zip
# php reset_geonames.php
*/
$data_src = __DIR__ . '/../sample_data/cities15000.txt';
$data_dst = __DIR__ . '/../sample_data/cities15000_min.txt';
$fileObj  = new SplFileObject($data_src, 'r');
$destObj  = new SplFileObject($data_dst, 'w');
while ($line = $fileObj->fgetcsv("\t")) {
    $line[3] = 'removed';
    $destObj->fputcsv($line, "\t");
}
unlink($data_src);
