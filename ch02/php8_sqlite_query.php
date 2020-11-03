<?php
// /repo/ch02/php8_sqlite_query.php
define('DB_FILE', __DIR__ . '/../sample_data/geonames.db');
try {
    $pdo = new PDO('sqlite:' . DB_FILE);
    $sql = 'SELECT * FROM geonames WHERE country_code = "IN" AND population > 2000000';
    $stmt = $pdo->query($sql);
    printf("%20s : %2s : %16s\n", 'City','CC', 'Population');
    printf("%20s : %2s : %16s\n", str_repeat('-', 20),'--', str_repeat('-', 16));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        printf("%20s : %2s : %16s\n",
            $row['name'],
            $row['country_code'],
            number_format($row['population']));
} catch (Exception $e) {
    echo $e;
}




