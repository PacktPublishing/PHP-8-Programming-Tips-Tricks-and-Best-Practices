<?php
// /repo/ch07/php7_simple_xml.php

function recurse($branch) {
    foreach ($branch as $node) {
        echo $node->descendent;
        echo ($node->descendent['gender'] == 'F')
             ? ', daughter of '
             : ', son of ';
        echo $node['name'];
        if (empty($node->spouse)) echo "\n";
        else echo ", married to {$node->spouse}\n";
        if (!empty($node->branch)) recurse($node->branch);
    }
}

$fn = __DIR__ . '/includes/tree.xml';
$xml = simplexml_load_file($fn);
recurse($xml);
