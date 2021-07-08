<?php
// /repo/ch08/php8_pgsql_changes.php

// before running this you need to do the following from a command prompt:
/*
# su postgres
bash-4.3$ psql
postgres=# CREATE DATABASE php8_tips;
postgres=# \c php8_tips;
postgres=# \i /repo/sample_data/pgsql_users_create.sql
postgres=# \q
bash-4.3$ exit
 */

$usr = 'php8';
$pwd = 'password';
$db  = pg_connect("host=localhost port=5432 dbname=php8_tips user=php8 password=password");
$sql = "SELECT * FROM users WHERE user_name='joe'";
$stmt = pg_query($db, $sql);
// deprecated
echo pg_errormessage();
$result = pg_fetch_all($stmt);
// no results now produce an empty array
var_dump($result);
