<?php
// /repo/ch010/php8_spl_obj_storage.php

require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();

// build response strategy container
use Services\ {SampleAccess,CountryInfo};
use Php7\Container\ResponseStrategy;
use Response\ {HtmlStrategy,JsonStrategy,XmlStrategy,TextStrategy};

// init strategies
$strategies = [
    'html' => HtmlStrategy::class,
    'json' => JsonStrategy::class,
    'xml'  => XmlStrategy::class,
    'text' => TextStrategy::class
];

// create strategy container based upon SplObjectStorage
$container = new ResponseStrategy($strategies);

// get sample data
$iter = SampleAccess::getData(6);

// alternate data source:
// $iter = (new CountryInfo())->getIterator();

echo $container->get(HtmlStrategy::class)->render($iter);
echo $container->get(JsonStrategy::class)->render($iter);
echo $container->get(XmlStrategy::class)->render($iter);
var_dump($container);
