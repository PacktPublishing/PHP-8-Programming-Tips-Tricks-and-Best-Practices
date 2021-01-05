<?php
// /repo/ch01/php7_switch.php
function get_symbol($iso) {
	switch ($iso) {
		case 'CNY' :
			$sym = '¥';
			break;
		case 'EUR' :
			$sym = '€';
			break;
		case 'EGP' :
		case 'GBP' :
			$sym = '£';
			break;
		case 'THB' :
			$sym = '฿';
			break;
		default :
			$sym = '$';
	}
	return $sym;
}
$test = ['CNY', 'EGP', 'EUR', 'GBP', 'THB', 'MXD'];
foreach ($test as $iso) {
	echo 'The currency symbol for ';
	echo $iso . ' is ';
	echo get_symbol($iso);
	echo "<br>\n";
}

