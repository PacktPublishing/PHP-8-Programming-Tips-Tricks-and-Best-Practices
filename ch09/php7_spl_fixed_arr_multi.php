<?php
// /repo/ch09/php7_spl_fixed_arr_multi.php
// using this data: https://download.geonames.org/export/dump/countryInfo.txt
// Columns (tab separated):
// ISO  ISO3    ISO-Numeric fips    Country Capital Area(in sq km)  Population  Continent   tld CurrencyCode
// CurrencyName Phone   Postal Code Format  Postal Code Regex   Languages   geonameid   neighbours  EquivalentFipsCode

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
    $child = SplFixedArray::fromArray($row);
    $countries[$pos] = $row[4];
    $arr[$pos++] = $child;
}

// sort by country name
asort($countries);

// display country info
$pattern = "";
foreach ($countries as $key => $value) {
    $name = $arr[$key][4] ?? 'Unknown';
    $iso2 = $arr[$key][0] ?? '???';
    $iso3 = $arr[$key][1] ?? '???';
    printf("%2s | %3s | %s\n", $iso2, $iso3, $name);
}

