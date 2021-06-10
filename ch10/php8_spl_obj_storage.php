<?php
// /repo/ch010/php8_spl_obj_storage.php

require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();

// build response strategy container
use Services\ {SampleAccess,CountryInfo};
use Php7\Container\ResponseStrategy;
use Response\ {HtmlStrategy,JsonStrategy,XmlStrategy,TextStrategy};

// create strategy container based upon SplObjectStorage
$container = new ResponseStrategy();

// retrieve strategy instances
$html = $container->get(HtmlStrategy::class);
$json = $container->get(JsonStrategy::class);
$xml  = $container->get(XmlStrategy::class);

// data source: access attempts
// $iter = SampleAccess::getData(6);

// data source: country information
$callback = function ($row) {
    return $row['Population'] > 300000000;
};
$source = new CountryInfo();
$iter = $source->getIterator('ISO3', $callback);

// render the sample data in different formats
echo $html->render($iter);
echo $xml->render($iter);
echo $json->render($iter);
