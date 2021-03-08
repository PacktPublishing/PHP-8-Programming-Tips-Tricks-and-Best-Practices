<?php
// /repo/ch05/php7_spl_spl_autoload_register.php

try {
    spl_autoload_register('does_not_exist', TRUE);
    $data = ['A' => [1,2,3],'B' => [4,5,6],'C' => [7,8,9]];
    $response = new \Application\Strategy\JsonResponse($data);
    echo $response->render();
} catch (Exception $e) {
    echo "A program error has occurred\n";
}
