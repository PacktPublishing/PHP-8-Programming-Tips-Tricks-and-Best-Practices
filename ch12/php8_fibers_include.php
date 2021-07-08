<?php
// /repo/ch12/php8_fibers_include.php
define('WAR_AND_PEACE', 'https://www.gutenberg.org/files/2600/2600-0.txt');
define('DB_FILE', __DIR__ . '/../sample_data/geonames.db');
define('ACCESS_LOG', __DIR__ . '/access.log');
$callbacks = [
    'read_url' =>
        function (string $url) {
            return file_get_contents($url);
        },
    'db_query' =>
        function (string $iso2) {
            $pdo = new PDO('sqlite:' . DB_FILE);
            $sql = 'SELECT * FROM geonames WHERE country_code = ?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$iso2]);
            return var_export($stmt->fetchAll(PDO::FETCH_ASSOC), TRUE);
        },
    'access_log' =>
        function (string $info) {
            $info = date('Y-m-d H:i:s') . ':' . $info . "\n";
            return file_put_contents(ACCESS_LOG, $info, FILE_APPEND);
        },
];
return $callbacks;
