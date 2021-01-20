<?php
// ch04/php8_ffi_cast.php

$patt = "%2d : %20s\n";
$int1 = FFI::new("int");
$int1->cdata = 123;
$bool = FFI::cast(FFI::type("bool"), $int1);
printf($patt, __LINE__, (string) $int1->cdata);
printf($patt, __LINE__, (string) $bool->cdata);

$int2 = FFI::new("int");
$int2->cdata = 123;
$float1 = FFI::cast(FFI::type("float"), $int2);
$int3   = FFI::cast(FFI::type("int"), $float1);
printf($patt, __LINE__, (string) $int2->cdata);
printf($patt, __LINE__, (string) $float1->cdata);
printf($patt, __LINE__, (string) $int3->cdata);

// FFI\Exception:attempt to cast to larger type
try {
    $float2 = FFI::new("float");
    $float2->cdata = 22/7;
    $char1   = FFI::cast(FFI::type("char[20]"), $float2);
    printf($patt, __LINE__, (string) $float2->cdata);
    printf($patt, __LINE__, (string) $char1->cdata);
} catch (Throwable $t) {
    echo get_class($t) . ':' . $t->getMessage();
}
echo "\n";
