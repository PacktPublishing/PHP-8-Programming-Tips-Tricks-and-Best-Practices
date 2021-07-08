<?php
// /repo/ch09/php7_PDO_query_signature.php

$reflect = new ReflectionClass('PDO');
$query   = $reflect->getMethod('query');
echo $query;

