<?php
// /repo/ch02/php8_arrow_func_3.php

/**
 * Generates text CAPTCHA
 *
 * @param string $text
 * @return string $captcha : text with HTML
 */
function textCaptcha(string $text)
{
	$algos = ['upper','lower','bold','italics','large','small'];
	$color = ['#EAA8A8','#B0F6B0','#F5F596','#E5E5E5','white','white'];
	shuffle($algos);
	shuffle($color);
	$bkgTmp = new ArrayIterator($color);
	$bkgIter = new InfiniteIterator($bkgTmp);
	$algoTmp = new ArrayIterator($algos);
	$algoIter = new InfiniteIterator($algoTmp);
	$len = strlen($text);
	$captcha = '';
	for ($x = 0; $x < $len; $x++) {
		$char = $text[$x];
		$bkg  = $bkgIter->current();
		$algo = $algoIter->current();
		$func = match ($algo) {
			'upper'   => fn() => strtoupper($char),
			'lower'   => fn() => strtolower($char),
			'bold'    => fn() => "<b>$char</b>",
			'italics' => fn() => "<i>$char</i>",
			'large'   => fn() => '<span style="font-size:32pt;">' . $char . '</span>',
			'small'   => fn() => '<span style="font-size:8pt;">' . $char . '</span>',
			default   => fn() => $char
		};
		$captcha .= '<span style="background-color:' . $bkg . ';">' . $func() . '</span>';
		$algoIter->next();
		$bkgIter->next();
	}
	return $captcha;
}
function genKey(int $size)
{
	$alpha1  = range('A','Z');
	$alpha2  = range('a','z');
	$special = '!@#$%^&*()_+,./[]{}|=-';
	$len     = strlen($special) - 1;
	$numeric = range(0, 9);
	$text    = '';
	for ($x = 0; $x < $size; $x++) {
		$algo = rand(1,4);
		$func = match ($algo) {
			1 => fn() => $alpha1[array_rand($alpha1)],
			2 => fn() => $alpha2[array_rand($alpha2)],
			3 => fn() => $special[rand(0,$len)],
			4 => fn() => $numeric[array_rand($numeric)],
			default => fn() => ' '
		};
		$text .= $func();			
	}
	return $text;
}

// generate random text
$text = genKey(8);
echo "Original: $text<br />\n";
echo 'Captcha : ' . textCaptcha($text) . "\n";
