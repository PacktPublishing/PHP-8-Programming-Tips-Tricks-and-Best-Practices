<?php
// /repo/sample_data/sqlite_geonames.php
// builds an SQLite database file from a subset of geonames
// see: https://download.geonames.org/export/dump/
/*
The main 'geoname' table has the following fields :
---------------------------------------------------
geonameid         : integer id of record in geonames database
name              : name of geographical point (utf8) varchar(200)
asciiname         : name of geographical point in plain ascii characters, varchar(200)
alternatenames    : alternatenames, comma separated, ascii names automatically transliterated, convenience attribute from alternatename table, varchar(10000)
latitude          : latitude in decimal degrees (wgs84)
longitude         : longitude in decimal degrees (wgs84)
feature class     : see http://www.geonames.org/export/codes.html, char(1)
feature code      : see http://www.geonames.org/export/codes.html, varchar(10)
country code      : ISO-3166 2-letter country code, 2 characters
cc2               : alternate country codes, comma separated, ISO-3166 2-letter country code, 200 characters
admin1 code       : fipscode (subject to change to iso code), see exceptions below, see file admin1Codes.txt for display names of this code; varchar(20)
admin2 code       : code for the second administrative division, a county in the US, see file admin2Codes.txt; varchar(80)
admin3 code       : code for third level administrative division, varchar(20)
admin4 code       : code for fourth level administrative division, varchar(20)
population        : bigint (8 byte int)
elevation         : in meters, integer
dem               : digital elevation model, srtm3 or gtopo30, average elevation of 3''x3'' (ca 90mx90m) or 30''x30'' (ca 900mx900m) area in meters, integer. srtm processed by cgiar/ciat.
timezone          : the iana timezone id (see file timeZone.txt) varchar(40)
modification date : date of last modification in yyyy-MM-dd format
*/
// scans geonames min database cities with > 15000 in population
define('TABLE', 'geonames');
$fields = [
    'geonameid' => 'INT PRIMARY KEY',
    'name'      => 'TEXT',
    'asciiname' => 'TEXT',
    'alternatenames' => 'TEXT',
    'latitude'  => 'REAL',
    'longitude' => 'REAL',
    'feature_class' => 'TEXT',
    'feature_code'  => 'TEXT',
    'country_code'  => 'TEXT',
    'cc2'         => 'TEXT',
    'admin1_code' => 'TEXT',
    'admin2_code' => 'TEXT',
    'admin3_code' => 'TEXT',
    'admin4_code' => 'TEXT',
    'population'  => 'INT',
    'elevation'   => 'INT',
    'dem'         => 'INT',
    'timezone'    => 'TEXT',
    'modification_date' => 'TEXT'
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
$target   = 1000000;
$data_src = __DIR__ . '/cities15000_min.txt';
$data_dst = __DIR__ . '/geonames.db';
if (file_exists($data_dst)) {
    unlink($data_dst);
    touch($data_dst);
    shell_exec('sqlite3 /repo/sample_data/geonames.db </repo/sample_data/sqlite_geonames_create.sql');
}
$fileObj  = new SplFileObject($data_src, 'r');
$pdo = new PDO('sqlite:' . $data_dst);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// init counters
$accepted = 0;
$added = 0;
$headers = array_keys($fields);
try {
    // truncate table
    $pdo->exec($drop);
    $stmt = $pdo->prepare($insert);
    while ($line = $fileObj->fgetcsv("\t")) {
        $name = $line[1] ?? 'Unknown';
        $pop = (int) ($line[14] ?? 0);
        if ($pop > $target) {
            $accepted++;
            echo "Adding: $name\n";
            // insert into SQLite database
            if (!count($line) == count($headers)) {
                echo "ERROR adding $name\n";
            } else {
                $data = array_combine($headers, $line);
                $stmt->execute($data);
                $added += $stmt->rowCount();
            }
        }
    }
} catch (Throwable $t) {
    echo $t;
}
echo "Lines Accepted: $accepted\n";
echo "Lines Added:    $added\n";
