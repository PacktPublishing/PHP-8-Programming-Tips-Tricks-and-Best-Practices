<?php
// /repo/ch02/php8_sqlite_auth_callback.php
define('DB_FILE', '/tmp/sqlite.db');
define('DEFAULT_USER', 'guest');
define('ACL' , [
    // user => [table => rights, table => rights, etc.]
    'admin' => [
        'users' => [SQLite3::READ, SQLite3::SELECT, SQLite3::INSERT, SQLite3::UPDATE, SQLite3::DELETE],
        'geonames' => [SQLite3::READ, SQLite3::SELECT, SQLite3::INSERT, SQLite3::UPDATE, SQLite3::DELETE],
    ],
    'guest' => [
        'geonames' => [SQLite3::READ, SQLite3::SELECT],
    ],
]);
// Normally $user would come from $_SESSION information
// Here we simulate the user using $_GET
session_start();
$_SESSION['user'] = $_GET['user'] ?? DEFAULT_USER;
$auth_callback = function ($code, ...$args)
{

    $status = SQLite3::DENY;
    $table  = 'Unknown';
    if ($code === SQLite3::SELECT) {
        $status = SQLite3::OK;
    } else {
        if (!empty($args[0])) {
            $table = $args[0];
        } elseif (!empty($_SESSION['table'])) {
            $table = $_SESSION['table'];
        }
        $user  = $_SESSION['user'] ?? DEFAULT_USER;
        // check to see if user is listed
        if (!empty(ACL[$user])) {
            // check to see if user is assigned to this table
            if (!empty(ACL[$user][$table])) {
                // check to see if code is allowed for this user and table
                if (in_array(ACL[$user][$table], $code)) {
                    $status = SQLite3::OK;
                }
            }
        }
    }
    echo 'Table:' . $table
         . ' | CODE: ' . $code
         . ' | ARGS: ' . implode(':', $args)
         . PHP_EOL;
    $_SESSION['table'] = $table;
    return $status;
};
echo '<pre>' . PHP_EOL;
try {
    $sqlite = new SQLite3(DB_FILE);
    $sqlite->setAuthorizer($auth_callback);
    $sql = 'SELECT * FROM geonames WHERE country_code = :cc AND population > :pop';
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
} catch (Exception $e) {
    echo $e;
}
echo "\n</pre>";
