<?php
// /repo/ch06/php8_locale_independent.php

// init vars
$list = ['en_GB', 'fr_FR', 'de_DE'];
$patt = "%15s | %15s \n";

// float-string-float for test locales
foreach ($list as $locale) {
    setlocale(LC_ALL, $locale);
    echo "Locale          : $locale\n";
    $f = 123456.789;
    echo "Original        : $f\n";
    $s = (string) $f;
    echo "Float to String : $s\n";
    $r = (float) $s;
    echo "String to Float : $r\n";
}
