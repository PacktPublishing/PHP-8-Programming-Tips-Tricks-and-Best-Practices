<?php
// /repo/sample_data/sqlite_geonames_country_info.php
// builds an SQLite database file from a subset of geonames
// see: https://download.geonames.org/export/dump/countryInfo.txt
/*
The main 'countries' table has the following fields :
---------------------------------------------------
iso2          : ISO 2 char code
iso3          : ISO 3 char code
iso           : ISO-Numeric code
fips          : fips
name          : Country Name
capital       : Capital City Name
area          : Area(in sq km)
pop           : Population
cont          : Continent
tld           : Top Level Domain (DNS)
currCode      : CurrencyCode
currName      : CurrencyName
phone         : Phone
postCodeFmt   : Postal Code Format
postCodeRegex : Postal Code Regex
lang          : Languages
geonameid     : geonameid
neighbors     : Neighbours
equivFips     : EquivalentFipsCode
*/
// scans geonames min database cities with > 15000 in population
define('TABLE',   'countries');
define('SRC_TXT', 'countryInfo.txt');
define('DB_FN',   'geonames.db');
// define function to skip lines
$skip = function ($line) { return (strpos($line[0], '#') === 0); };
// field defs
$fields = [
    'iso'           => 'INT PRIMARY KEY',
    'iso2'          => 'TEXT',
    'iso3'          => 'TEXT',
    'fips'          => 'TEXT',
    'name'          => 'TEXT',
    'capital'       => 'TEXT',
    'area'          => 'INT',
    'pop'           => 'INT',
    'cont'          => 'TEXT',
    'tld'           => 'TEXT',
    'currCode'      => 'TEXT',
    'currName'      => 'TEXT',
    'phone'         => 'TEXT',
    'postCodeFmt'   => 'TEXT',
    'postCodeRegex' => 'TEXT',
    'lang'          => 'TEXT',
    'neighbors'     => 'TEXT',
    'equivFips'     => 'TEXT',
    'geonameid'     => 'INT',
];
// build SQL for DROP and CREATE
$drop   = 'DELETE FROM ' . TABLE . ';';
$create = 'CREATE TABLE IF NOT EXISTS ' . TABLE . ' (';
foreach ($fields as $name => $type)
    $create .= "\n    $name $type,";
$create = substr($create, 0, -1);
$create .= ');';
echo $create . "\n";
// build SQL for INSERT
$insert = 'INSERT INTO ' . TABLE . ' ('
        . implode(',', array_keys($fields))
        . ') VALUES (:'
        . implode(',:', array_keys($fields))
        . ');';

// set up for population
$data_src = __DIR__ . '/' . SRC_TXT;
$data_dst = __DIR__ . '/' . DB_FN;
$fileObj  = new SplFileObject($data_src, 'r');
$pdo      = new PDO('sqlite:' . $data_dst);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// init counters
$accepted = 0;
$added    = 0;
$headers  = array_keys($fields);
$ctrl     = count($headers);
try {
    // create table if not exists
    $pdo->exec($create);
    // truncate
    $pdo->exec($drop);
    $stmt = $pdo->prepare($insert);
    while ($line = $fileObj->fgetcsv("\t")) {
        if ($skip($line)) continue;
        $name = $line[4] ?? 'Unknown';
        echo "Adding: $name\n";
        // insert into SQLite database
        if (!count($line) == count($headers)) {
            echo "ERROR adding $name\n";
        } else {
            if (count($line) === $ctrl) {
                $data = array_combine($headers, $line);
                $stmt->execute($data);
                $added += $stmt->rowCount();
            } else {
                echo "ERROR adding $name\n";
            }
        }
    }
} catch (Throwable $t) {
    echo $t;
}
echo "Lines Accepted: $accepted\n";
echo "Lines Added:    $added\n";
