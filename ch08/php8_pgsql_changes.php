<?php
// /repo/ch08/php8_pgsql_changes.php

/*
 *  before running this you need to do the following from a command prompt:
 * /etc/init.d/postgresql start
 */

// connect params
$dsn = 'host=localhost '
     . 'port=5432 '
     . 'dbname=php8_tips '
     . 'user=php8 '
     . 'password=password';
$db  = pg_connect($dsn);
// deprecated
echo 'Connect errors (if any): ' . pg_errormessage() . "\n";
if ($db !== FALSE) {
    // show that users exist:
    $sql = "SELECT * FROM users";
    $stmt = pg_query($db, $sql);
    $result = pg_fetch_all($stmt);
    foreach ($result as $row) echo implode("\t", $row) . "\n";
    // user "joe" doesn't exist:
    $sql = "SELECT * FROM users WHERE user_name='joe'";
    $stmt = pg_query($db, $sql);
    $result = pg_fetch_all($stmt);
    // no results now produce an empty array
    var_dump($result);
} else {
    echo "\nPostgreSQL is not running\n";
}
