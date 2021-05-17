<?php
// /repo/ch07/php8_xml_writer.php

$xml = new XMLWriter();
$xml->openMemory();
$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('fruit');
$xml->startElement('item');
$xml->text('Apple');
$xml->endElement();
$xml->startElement('item');
$xml->text('Banana');
$xml->endElement();
$xml->endElement();
$xml->endDocument();
echo $xml->outputMemory();
