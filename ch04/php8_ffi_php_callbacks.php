<?php
$zend = FFI::cdef("
    typedef int (*zend_write_func_t)(const char *str, size_t str_length);
    extern zend_write_func_t zend_write;
");

echo "Original echo command does not output LF:\n";
echo 'A','B','C';
echo 'Next line';
echo "\n";

$orig_zend_write = clone $zend->zend_write;
$zend->zend_write = function($str, $len) {
    global $orig_zend_write;
    $ret = $orig_zend_write($str, $len);
    $orig_zend_write("\n", 1);
    return $ret;
};

echo 'Revised echo command adds LF:';
echo 'A','B','C';
print('Also affects print:');
print('A');
print('B');
print('C');
