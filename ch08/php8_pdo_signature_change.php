<?php
// /repo/ch08/php8_pdo_signature_change.php

$config = include __DIR__ . '/../src/config/config.php';
$db_cfg = $config['db-config'];
$pdo    = new PDO($db_cfg['dsn'], $db_cfg['usr'], $db_cfg['pwd']);
$sql    = 'SELECT hotelName, city, locality, country, postalCode '
        . 'FROM hotels '
        . 'WHERE country = ? AND city = ?';
$stmt   = $pdo->prepare($sql);

// fetch mode PDO::FETCH_ASSOC
echo "Using PDO::FETCH_ASSOC\n";
$stmt->execute(['IN', 'Budhera']);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $stmt->fetch()) var_dump($row);

// fetch mode PDO::FETCH_CLASS
echo "\nUsing PDO::FETCH_CLASS\n";
$stmt->execute(['IN', 'Budhera']);
$stmt->setFetchMode(PDO::FETCH_CLASS, ArrayObject::class);
while ($row = $stmt->fetch()) var_dump($row);

