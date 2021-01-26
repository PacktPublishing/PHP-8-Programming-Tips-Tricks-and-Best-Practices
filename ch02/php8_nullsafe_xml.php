<?php
// /repo/ch02/php8_nullsafe_xml.php
$xml = simplexml_load_file(__DIR__ . '/includes/produce.xml');
$produce = [
	'fruit' => ['apple','banana','cherry','pear'],
	'vegetable' => ['artichoke','beans','cabbage','squash']
];
$pattern = "%10s : %d\n";
foreach ($produce as $type => $items) {
	echo ucfirst($type) . ":\n";
	foreach ($items as $item) {
		printf($pattern, $item, $xml?->dept?->$type?->$item);
	}
}
