<?php
// /repo/ch02/php8_nested_ternary.php
function show($matching, $non_match)
{
    echo "\nChapter PHP Files: " . count($matching) . "<br />\n";
    echo "Non Matching: " . count($non_match) . "<br />\n";
}
function find_using_if($iter, $searchPath, $searchExt)
{
    $matching  = [];
    $non_match = [];
    $discard   = [];
    foreach ($iter as $name => $obj) {
        if (!$obj->isFile()) {
            $discard[] = $name;
        } elseif (!strpos($name, $searchPath)) {
            $discard[] = $name;
        } elseif ($obj->getExtension() !== $searchExt) {
            $non_match[] = $name;
        } else {
            $matching[] = $name;
        }
    }
    show($matching, $non_match);
}
function find_using_ternary($iter, $searchPath, $searchExt)
{
    $matching  = [];
    $non_match = [];
    $discard   = [];
    foreach ($iter as $name => $obj) {
        $match = !$obj->isFile()
            ? $discard[] = $name
            : !strpos($name, $searchPath)
                ? $discard[] = $name
                : $obj->getExtension() !== $searchExt
                    ? $non_match[] = $name
                    : $matching[] = $name;
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

// output:
// Fatal error: Unparenthesized `a ? b : c ? d : e` is not supported.
// Use either `(a ? b : c) ? d : e` or `a ? b : (c ? d : e)` in /repo/ch02/php8_nested_ternary.php on line 32
