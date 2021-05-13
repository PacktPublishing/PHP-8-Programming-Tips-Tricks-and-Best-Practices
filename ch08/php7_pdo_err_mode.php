<?php
// /repo/ch08/php7_pdo_err_mode.php

$dsn = 'mysql:host=localhost;dbname=php8_tips';
$usr = 'php8';
$pwd = 'password';
$pdo = new PDO($dsn, $usr, $pwd);
$sql = 'SELEK propertyKey, hotelName FUM hotels '
     . "WARE country = 'CA'";
$stm = $pdo->query($sql);
if ($stm) {
    while($hotel = $stm->fetch(PDO::FETCH_OBJ))
        echo $hotel->name . ' ' . $hotel->key . "\n";
} else {
    echo "No Results\n";
}
