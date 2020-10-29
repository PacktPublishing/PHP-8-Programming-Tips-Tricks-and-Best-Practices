<?php
// /repo/ch02/php7_arbitrary_exp.php
$nav = [
    'home'     => 'home.html',
    'about'    => 'about.html',
    'services' => 'services/index.html',
    'support'  => 'support/index.html',
];
$html = __DIR__ . '/../includes/'
      . $nav[$_GET['page'] ?? 'home'];
echo $html;
