<?php
// /repo/ch01/php8_switch.php
function get_symbol(string $iso) {
	return match ($iso) {
	    'EGP','GBP' => '£',
	    'CNY'       => '¥',
	    'EUR'       => '€',
	    'THB'       => '฿',
	    default     => '$'
	};
}
$test = ['CNY', 'EGP', 'EUR', 'GBP', 'THB', 'MXD'];
foreach ($test as $iso) {
	echo 'The currency symbol for ';
	echo $iso . ' is ';
	echo get_symbol($iso);
	echo "<br>\n";
}

