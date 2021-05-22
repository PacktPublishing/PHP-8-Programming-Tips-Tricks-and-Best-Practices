<?php
// /repo/ch09/php8_dom_changes.php

$doc = new DomDocument();
$doc->loadHTMLFile('dom_test_1.html');

$reflect = new ReflectionObject($doc);
echo $reflect;
