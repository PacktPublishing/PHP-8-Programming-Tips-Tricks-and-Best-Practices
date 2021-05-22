<?php
// /repo/ch09/php7_class_and_obj.php
try {
    $pdo = new PDO();
    echo 'No problem';
} catch (Throwable $t) {
    echo get_class($t) . ':' . $t->getMessage();
}
echo "\n";
