<?php
// /repo/ch07/php8_simple_xml.php

$fn = __DIR__ . '/includes/tree.xml';
$xml = simplexml_load_file($fn);
$iter = new RecursiveIteratorIterator($xml, RecursiveIteratorIterator::SELF_FIRST);
foreach ($iter as $branch) {
    if (!empty($branch->descendent)) {
        echo $branch->descendent;
        echo ($branch->descendent['gender'] == 'F')
             ? ', daughter of '
             : ', son of ';
        echo $branch['name'];
        if (empty($branch->spouse)) echo "\n";
        else echo ", married to {$branch->spouse}\n";
    }
}
