<?php
// /repo/ch06/php8_parse_url_parse_str.php
require __DIR__ . '/../src/Http/Request.php';
use Http\Request;
$data = [
    'http://doug:password@test.com:8888/demo#partial',
    'https://duckduckgo.com/?q=PHP+url+handling&t=h_&ia=web',
];
foreach ($data as $url)
    var_dump(new Request($url));

