<?php
// /repo/ch09/php8_class_and_obj.php
try {
    $pdo = new PDO();
    echo 'No problem';
} catch (Throwable $t) {
    echo $t::class . ':' . $t->getMessage();
}
echo "\n";
