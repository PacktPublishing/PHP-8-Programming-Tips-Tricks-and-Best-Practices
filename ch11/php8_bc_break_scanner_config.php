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
                return (preg_match('/__construct.*?\{.*?(die|exit).*?}/im', $contents)
                        && strpos('__destruct', $contents));
            },
            'msg' => 'WARNING: __destruct() might not get called if "die()" or "exit()" used in __construct()'],
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
            'msg' => 'WARNING: need to confirm __sleep() return values match properties'],
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
    'removed' => [
        'image2wbmp' => 'imagebmp',
        'png2wbmp' => 'imagebmp',
        'jpeg2wbmp' => 'imagebmp',
        'gmp_random' => 'gmp_random_range',
        'imap_header' => 'imap_headerinfo',
        'ldap_sort'  => 'ldap_get_entries() combined with usort()',
        'ldap_control_paged_result'  => 'ldap_get_entries() combined with usort()',
        'ldap_control_paged_result_response' => 'ldap_get_entries() combined with usort()',
        'mbregex_encoding' => 'mb_regex_encoding',
        'mbereg' => 'mb_ereg',
        'mberegi' => 'mb_eregi',
        'mbereg_replace' => 'mb_ereg_replace',
        'mberegi_replace' => 'mb_eregi_replace',
        'mbsplit' => 'mb_split',
        'mbereg_match' => 'mb_ereg_match',
        'mbereg_search' => 'mb_ereg_search',
        'mbereg_search_pos' => 'mb_ereg_search_pos',
        'mbereg_search_regs' => 'mb_ereg_search_regs',
        'mbereg_search_init' => 'mb_ereg_search_init',
        'mbereg_search_getregs' => 'mb_ereg_search_getregs',
        'mbereg_search_getpos' => 'mb_ereg_search_getpos',
        'mbereg_search_setpos' => 'mb_ereg_search_setpos',
        'oci_internal_debug' => 'oci_error',
        'ociinternaldebug' => 'oci_error',
        'hebrevc' => 'No replacement',
        'convert_cyr_string' => 'No replacement',
        'money_format' => 'No replacement',
        'ezmlm_hash' => 'No replacement',
        'restore_include_path' => 'No replacement',
        'get_magic_quotes_gpc' => 'No replacement',
        'get_magic_quotes_runtime' => 'No replacement',
        'fgetss' => 'strip_tags(fgets($fh))',
        'gzgetss' => 'No replacement',
    ],
];
