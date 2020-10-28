<?php
// /repo/ch02/php8_arrow_func_3.php

function textCaptcha($text)
{
	$algos = ['upper','lower','bold','italics','large','small'];
	$rand  = rand(1,3);
	shuffle($algos);
	$iter = new ArrayIterator($algos);
	$len = strlen($text);
	$captcha = '';
	for ($x = 0; $x < $len; $x++) {
		$char = $text[$x];
		$algo = $iter->current();
		$func = match ($algo) {
			'upper'   => fn() => strtoupper($char),
			'lower'   => fn() => strtolower($char),
			'bold'    => fn() => "<b style='color:red;'>$char</b>",
			'italics' => fn() => "<i style='color:green;'>$char</i>",
			'large'   => fn() => '<span style="font-size:16px;">' . $char . '</span>',
			'small'   => fn() => '<span style="font-size:8px;">' . $char . '</span>',
			default   => fn() => $char
		};
		$captcha .= $func();
		$iter->next();
		if (!$iter->valid()) $iter->rewind();
	}
	return $captcha;
}
// generate random text
$alpha = range('A','Z');
$numeric = range(0, 9);
$text =	$alpha[array_rand($alpha)]
	  . $numeric[array_rand($numeric)]
	  . $alpha[array_rand($alpha)]
	  . $numeric[array_rand($numeric)]
	  . $alpha[array_rand($alpha)]
	  . $numeric[array_rand($numeric)]
	  . $alpha[array_rand($alpha)]
	  . $numeric[array_rand($numeric)];

echo "Original: $text<br />\n";
echo 'Captcha : ' . textCaptcha($text) . "\n";
