<?php
// /repo/ch02/php8_arrow_func_3.php

function number2words(int $num)
{
	$words = '';
	$range = [
		10 => ['zero','one','two','three','four','five','six','seven','eight','nine'],
		20 => ['ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'],
		100 => [2 => 'twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety'],
	];
	$str = (string) $num;
	$len = strlen($str) - 1;
	for ($x = $len; $x >= 0; $x--) {
		if ($num < 10) {
			$words .= $range[10][(int) $str[$x]] ?? '';
		} elseif ($num < 20 && $num >= 10) {
			$words .= $range[20][(int) $str[$x]] ?? '';
		} elseif ($num < 100 && $num >= 20) {
			$words .= $range[100][(int) $str[$x]] ?? '';
		} elseif ($num < 1000 && $num >= 100) {
			$words .= $range[10][(int) $str[$x]] ?? '';
			$words .= ' ';
			$words .= 'hundred';
		} elseif ($num < 1010 && $num >= 1000) {
			$words .= $range[10][(int) $str[$x]] ?? '';
			$words .= ' ';
			$words .= 'thousand';
		} elseif ($num < 1020 && $num >= 1010) {
			$words .= $range[20][(int) $str[$x]] ?? '';
			$words .= ' ';
			$words .= 'thousand';
		}
		$words .= ' ';
		$num = (int) $num / 10;
	}
	return $words;
}
echo number2words(101);
