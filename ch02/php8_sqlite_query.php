<?php
// /repo/ch02/php8_sqlite_query.php
define('DB_FILE', '/tmp/sqlite.db');
try {
    $sqlite = new SQLite3(DB_FILE);
    $sql = 'SELECT * FROM geonames WHERE country_code = :cc AND population > :pop';
    $stmt = $sqlite->prepare($sql);
    $stmt->bindValue(':cc', 'IN');
    $stmt->bindValue(':pop', 2000000);
    $result = $stmt->execute();
    echo '<pre>' . PHP_EOL;
    printf("%20s : %2s : %16s\n", 'City','CC', 'Population');
    printf("%20s : %2s : %16s\n", str_repeat('-', 20),'--', str_repeat('-', 16));
    while ($row = $result->fetchArray(SQLITE3_ASSOC))
        printf("%20s : %2s : %16s\n",
            $row['name'],
            $row['country_code'],
            number_format($row['population']));
} catch (Exception $e) {
    echo $e;
}
echo "\n</pre>";
