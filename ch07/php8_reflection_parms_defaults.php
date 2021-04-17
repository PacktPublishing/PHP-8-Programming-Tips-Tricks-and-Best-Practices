<?php
// /repo/ch07/php8_reflection_parms_defaults.php

$func = function (ReflectionParameter $parm) {
    $name = $parm->getName();
    $opts = NULL;
    if ($parm->isDefaultValueAvailable())
        $opts = $parm->getDefaultValue();
    switch (TRUE) {
        case (is_array($opts)) :
            $tmp = '';
            foreach ($opts as $key => $val)
                $tmp .= $key . ':' . $val . ',';
            $opts = substr($tmp, 0, -1);
            break;
        case (is_bool($opts)) :
            $opts = ($opts) ? 'TRUE' : 'FALSE';
            break;
        case ($opts === '') :
            $opts = "''";
            break;
        default :
            $opts = 'No Default';
    }
    return [$name, $opts];
};

$test = 'setcookie';
$ref = new ReflectionFunction($test);
$parms = $ref->getParameters();

echo "Reflecting on $test\n";
$patt = "%18s : %s\n";
printf($patt, 'Parameter', 'Default(s)');
printf($patt, str_repeat('-', 12), str_repeat('-', 12));
foreach ($parms as $obj)
    vprintf($patt, $func($obj));
