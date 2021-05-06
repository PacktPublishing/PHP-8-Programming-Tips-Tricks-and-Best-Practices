<?php
// /repo/ch08/php7_preg_replace_e_modifier.php

$text = 'The quick brown FOX jumped over the FENCE';
$patt = '/(F.+?\b)/e';
$repl = 'strtolower($1)';
$new  = preg_replace($patt, $repl, $text);
echo $text . "\n";
echo $new . "\n";
