<?php
// /repo/ch010/php7_weak_map_problem.php

require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
require __DIR__ . '/vendor/autoload.php';   // composer autoloader
use Zend\Filter\ {StringTrim, StripNewlines, StripTags, ToInt, Whitelist, UriNormalize};
use Php7\Container\UsesSplObjectStorage;

// simulated form posting data
$data = [
    'name'    => '<script>bad JavaScript</script>name',
    'status'  => 'should only contain digits 9999',
    'gender'  => 'FMZ only allowed M, F or X',
    'space'   => "  leading/trailing whitespace or\n",
    'url'     => 'unlikelysource.com/about',
];

// assign additional filters to fields
$required = [
    StringTrim::class,
    StripNewlines::class,
    StripTags::class
];
$added = [
    'status'  => ToInt::class,
    'gender'  => Whitelist::class,
    'url'     => UriNormalize::class,
];

// build filters
$filters = [
    new StringTrim(),
    new StripNewlines(),
    new StripTags(),
    new ToInt(),
    new Whitelist(['list' => ['M','F','X']]),
    new UriNormalize(['enforcedScheme' => 'https']),
];

// load up filters into container
$container = new UsesSplObjectStorage($filters);

// filter fields
foreach ($data as $key => &$value) {
    foreach ($required as $class) {
        $value = $container->get($class)->filter($value);
    }
    if (isset($added[$key])) {
        $value = $container->get($added[$key])->filter($value);
    }
}

// sanitized data
var_dump($data);

// get memory usage
$mem = memory_get_usage();

// get rid of filters
unset($filters);

// force garbage collection
gc_collect_cycles();

// get memory usage
$end = memory_get_usage();
echo "\nMemory Before Unset: $mem\n";
echo "Memory After  Unset: $end\n";
echo 'Difference         : ' . ($mem - $end) . "\n";
echo 'Peak Memory Usage  : ' . memory_get_peak_usage() . "\n";
