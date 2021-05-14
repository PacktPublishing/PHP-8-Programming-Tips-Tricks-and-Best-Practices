<?php
// /repo/ch09/php7_spl_fixed_arr_iter.php
// using this data: https://download.geonames.org/export/dump/countryInfo.txt

$src = __DIR__ . '/../sample_data/countryInfo.txt';
$pos = 0;
$obj = new SplFileObject($src, 'r');
$arr = new SplFixedArray(300);

// place country info into SplFixArray
while (!$obj->eof()) {
    $row = $obj->fgetcsv("\t");
    $leading = $row[0][0] ?? FALSE;
    if (!$leading) continue;
    if ($leading == '#') continue;
    $child = new SplFixedArray(count($row));
    foreach ($row as $key => $item) {
        $child[$key] = $item;
    }
    $arr[$pos++] = $child;
}

// display country info
$pattern = "";
foreach ($arr as $info) {
    if(empty($info)) continue;
    $str = [];
    $str[] = $info[1] ?? '???';     // ISO3
    $str[] = $info[10] ?? '???';    // currency
    $str[] = $info[5] ?? 'Unknown'; // name
    vprintf("%3s | %3s | %s\n", $str);
}

