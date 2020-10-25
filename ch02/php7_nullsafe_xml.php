<?php
// /repo/ch02/php7_nullsafe_xml.php
function getQuantity(SimpleXMLElement $xml, string $type, string $item)
{
	$qty = 0;
	if (!empty($xml->dept)) {
		if (!empty($xml->dept->$type)) {
			if (!empty($xml->dept->$type->$item)) {
				$qty = $xml->dept->$type->$item;
			}
		}
	}
	return $qty;
}
$xml = simplexml_load_file(__DIR__ . '/includes/produce.xml');
$produce = [
	'fruit' => ['apple','banana','cherry','pear'],
	'vegetable' => ['artichoke','beans','cabbage','squash']
];
$pattern = "%10s : %d\n";
foreach ($produce as $type => $items) {
	echo ucfirst($type) . ":\n";
	foreach ($items as $item) {
		$qty = getQuantity($xml, $type, $item);
		printf($pattern, $item, $qty);
	}
}
