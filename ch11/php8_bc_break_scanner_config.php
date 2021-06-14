<?php
// /repo/src/config/bc_break_scanner.config.php
// config file for Migration\OopBreakScan

return [
    'scans' => [
        'ERR_CLASS_CONSTRUCT' => [
            'callback' => function ($class, $contents) {
                return ((stripos($contents, 'function ' . $class . '('))
                    || (stripos($contents, 'function ' . $class . ' (')))
                    && (stripos($contents, 'function __construct'));
            },
            'msg' => 'WARNING: contains method same name as class but no __construct() method defined.  Can no longer use method with same name as the class as a constructor.'],
        'ERR_CONST_EXIT'      => [
            'callback' => function ($class, $contents) {
                $regex = '/__construct.*?\{.*?(die|exit).*?}/im';
                return (preg_match($regex, $temp) && strpos('__destruct', $contents));
            },
            'msg' => 'WARNING: __destruct() might not get called if "die()" or "exit()" used in __construct()',
        'ERR_SPL_FGETSS'      => [
            'callback' => function ($class, $contents) {
                return  (stripos($contents, 'SplFileObject'))
                    &&  (stripos($contents, '->fgetss()'));
            },
            'msg' => 'WARNING: support for SplFileObject::fgetss() has been removed: use "strip_tags(SplFileObject::fgets())" instead'],
        'ERR_MAGIC_SLEEP'     => [
            'callback' => function ($class, $contents) {
                return strpos($contents, 'function __sleep');
            },
            'msg' => 'WARNING: need to confirm __sleep() return values match properties',
        'ERR_MAGIC_AUTOLOAD'  => [
            'callback' => function ($class, $contents) {
                return stripos($contents, 'function __autoload');
            },
            'msg' => 'WARNING: the "__autoload()" function is removed in PHP 8: replace with "spl_autoload_register()"'],
        'ERR_MATCH_KEYWORD'   => [
            'callback' => function ($class, $contents) {
                return preg_match('/function\s+match(\s)?\(/', $contents);
            },
            'msg' => 'WARNING: "match" is now a reserved key word'],
        'ERR_PHP_ERRORMSG'    => [
            'callback' => function ($class, $contents) {
                return strpos($contents, 'php_errormsg');
            },
            'msg' => 'WARNING: the "track_errors" php.ini directive is removed.  You can no longer rely upon "$php_errormsg".'],
        'ERR_DEFINE_THIRD_ARG'    => [
            'callback' => function ($class, $contents) {
                return preg_match('/define(\s)?\(.+?,.+?,(\s)?TRUE/i', $contents);
            },
            'msg' => 'WARNING: the third argument to "define()" needs to be FALSE. Constants are now always case sensitive'],
        'ERR_CREATE_FUNCTION'    => [
            'callback' => function ($class, $contents) {
                return (strpos($contents, ' create_function(') || strpos($contents, ' create_function ('));
            },
            'msg' => 'WARNING: "create_function()" has been removed.  Use anonymous functions instead.'],
        'ERR_EACH'    => [
            'callback' => function ($class, $contents) {
                return (strpos($contents, ' each(') || strpos($contents, ' each ('));
            },
            'msg' => 'WARNING: "each()" has been removed.  Use "foreach()" or an ArrayIterator instead.'],
        'ERR_ATTRIBUTES'    => [
            'callback' => function ($class, $contents) {
                return preg_match('/\s#\[/', $contents);
            },
            'msg' => 'WARNING: comments that begin with "#[" are no longer allowed.  You should convert these into Attributes instead.'],
        'ERR_LOCALE_INDEPENDENCE'    => [
            'callback' => function ($class, $contents) {
                return (stripos($contents, ' setlocale(') || strpos($contents, ' setlocale ('));
            },
            'msg' => 'WARNING: if you have a float-to-string typecast (implicit or explicit), the output will no longer be in the set locale.  Use "printf()", "number_format()" or the NumberFormatter class instead.'],
        'ERR_ASSERT_IN_NAMESPACE'    => [
            'callback' => function ($class, $contents) {
                return (preg_match('/namespace.*?function assert(\s)?\(/', $contents));
            },
            'msg' => 'WARNING: "assert()" is now a reserved function name, even when used inside a namespace.  You must rename this function to something else.'],
        'ERR_REFLECTION_EXPORT'    => [
            'callback' => function ($class, $contents) {
                return (preg_match('/Reflection.*?::export(\s)?\(/', $contents));
            },
            'msg' => 'WARNING: Reflection::export() has been removed.  Echo the Reflection object or use its "__toString()" method.'],
    ],
    'messages' => [
        'WARN_BC_BREAKS'  => 'WARNING: the code scanned might not be compatible with PHP 8',
        'NO_BC_BREAKS'    => 'SUCCESS: it appears that the code scanned is potentially compatible with PHP 8',
    ]
];
