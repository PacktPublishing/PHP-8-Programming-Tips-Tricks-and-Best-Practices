<?php
// /repo/ch10/php8_jit_debug_values.php
// see: https://github.com/php/php-src/blob/master/ext/opcache/jit/zend_jit.h

$vals = <<<EOT
#define ZEND_JIT_DEBUG_ASM       (1<<0)
#define ZEND_JIT_DEBUG_SSA       (1<<1)
#define ZEND_JIT_DEBUG_REG_ALLOC (1<<2)
#define ZEND_JIT_DEBUG_ASM_STUBS (1<<3)
#define ZEND_JIT_DEBUG_PERF      (1<<4)
#define ZEND_JIT_DEBUG_PERF_DUMP (1<<5)
#define ZEND_JIT_DEBUG_OPROFILE  (1<<6)
#define ZEND_JIT_DEBUG_VTUNE     (1<<7)
#define ZEND_JIT_DEBUG_GDB       (1<<8)
#define ZEND_JIT_DEBUG_SIZE      (1<<9)
#define ZEND_JIT_DEBUG_ASM_ADDR  (1<<10)
#define ZEND_JIT_DEBUG_TRACE_START     (1<<12)
#define ZEND_JIT_DEBUG_TRACE_STOP      (1<<13)
#define ZEND_JIT_DEBUG_TRACE_COMPILED  (1<<14)
#define ZEND_JIT_DEBUG_TRACE_EXIT      (1<<15)
#define ZEND_JIT_DEBUG_TRACE_ABORT     (1<<16)
#define ZEND_JIT_DEBUG_TRACE_BLACKLIST (1<<17)
#define ZEND_JIT_DEBUG_TRACE_BYTECODE  (1<<18)
#define ZEND_JIT_DEBUG_TRACE_TSSA      (1<<19)
#define ZEND_JIT_DEBUG_TRACE_EXIT_INFO (1<<20)
EOT;
foreach (explode("\n", $vals) as $line) {
    $split = explode(' ', $line);
    $name  = $split[1];
    $tmp   = array_pop($split);
    $shift = (int) (str_replace(['(','1<<',')'], '', $tmp));
    $size  = 1 << $shift;
    printf("%30s : %8d\n", $name, $size);
}
