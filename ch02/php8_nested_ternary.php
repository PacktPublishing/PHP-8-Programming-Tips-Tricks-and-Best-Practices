<?php
// /repo/ch02/php8_nested_ternary.php
function show($matching, $non_match)
{
    echo "\nChapter PHP Files: " . count($matching) . "<br />\n";
    echo "Non Matching: " . count($non_match) . "<br />\n";
}
function find_using_if($iter, $searchPath, $searchExt)
{
    $matching = [];
    $non_match = [];
    foreach ($iter as $name => $obj) {
        if ($obj->isFile()) {
            if (strpos($name, $searchPath)) {
                if ($obj->getExtension() === $searchExt) {
                    $matching[] = $name;
                } else {
                    $non_match[] = $name;
                }
            }
        }
    }
    show($matching, $non_match);
}
function find_using_ternary($iter, $searchPath, $searchExt)
{
    $matching = [];
    $non_match = [];
    foreach ($iter as $name => $obj) {
        $match = $obj->isFile()
            ? strpos($name, $searchPath)
                ? $obj->getExtension() === $searchExt
                    ? $matching[] = $name
                    : $non_match[] = $name
                : FALSE
            : FALSE;
    }
    show($matching, $non_match);
}
$path = realpath(__DIR__ . '/..');
$searchPath = '/ch';
$searchExt  = 'php';
$dirIter    = new RecursiveDirectoryIterator($path);
$itIter     = new RecursiveIteratorIterator($dirIter);
find_using_if($itIter, $searchPath, $searchExt);
find_using_ternary($itIter, $searchPath, $searchExt);
