<?php
// /repo/ch02/php8_sqlite_auth_callback.php
include __DIR__ . '/includes/auth_callback.php';
// Normally $user would come from $_SESSION information
// Here we simulate the user using $_GET
session_start();
$_SESSION['user'] = $_GET['user'] ?? DEFAULT_USER;
echo '<pre>' . PHP_EOL;
try {
    $msg = sprintf(PATTERN, 'TABLE', 'CODE',  'ARGS', 'SESS');
    error_log($msg);
    $sqlite = new SQLite3(DB_FILE);
    $sqlite->setAuthorizer('auth_callback');
    $sql = 'SELECT name,country_code,population FROM geonames WHERE country_code = :cc AND population > :pop';
    $stmt = $sqlite->prepare($sql);
    if ($stmt) {
        $stmt->bindValue(':cc', 'IN');
        $stmt->bindValue(':pop', 2000000);
        $result = $stmt->execute();
        printf("%20s : %2s : %16s\n", 'City','CC', 'Population');
        printf("%20s : %2s : %16s\n", str_repeat('-', 20),'--', str_repeat('-', 16));
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
            printf("%20s : %2s : %16s\n",
                $row['name'],
                $row['country_code'],
                number_format($row['population']));
    }
} catch (Throwable $e) {
    error_log(get_class($e) . ':' . $e->getMessage());
}
echo "\n</pre>";
