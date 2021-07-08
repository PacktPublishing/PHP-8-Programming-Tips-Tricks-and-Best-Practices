<?php
// /repo/ch11/bc_break_scanner.config.php
// config file for Migration\BreakScan
use Php8\Migration\BreakScan;
return [
    // key) removed function => (value) suggested replacement
    BreakScan::KEY_REMOVED => [
        'function __autoload' => 'spl_autoload_register(callable)',
        'function __sleep' => 'Need to confirm __sleep() returns an array of existing property names.  Consider using __serialize() instead.',
        'convert_cyr_string' => 'No replacement',
        'create_function' => 'Use either "function () {}" or "fn () => <expression>"',
        'each' => 'Use "foreach()" or ArrayIterator',
        'ezmlm_hash' => 'No replacement',
        'fgetss' => 'strip_tags(fgets($fh))',
        'get_magic_quotes_gpc' => 'No replacement',
        'get_magic_quotes_runtime' => 'No replacement',
        'gmp_random' => 'gmp_random_range',
        'gzgetss' => 'No replacement',
        'hebrevc' => 'No replacement',
        'image2wbmp' => 'imagebmp',
        'imap_header' => 'imap_headerinfo',
        'is_real' => 'is_float',
        'jpeg2wbmp' => 'imagebmp',
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
        'money_format' => 'NumberFormatter::formatCurrency',
        'oci_internal_debug' => 'oci_error',
        'ociinternaldebug' => 'oci_error',
        'pg_errormessage' =>    'pg_last_error',
        'pg_numrows' => 'pg_num_rows',
        'pg_numfields' =>   'pg_num_fields',
        'pg_cmdtuples' =>   'pg_affected_rows',
        'pg_fieldname' =>   'pg_field_name',
        'pg_fieldsize' =>   'pg_field_size',
        'pg_fieldtype' =>   'pg_field_type',
        'pg_fieldnum' =>    'pg_field_num',
        'pg_result' =>  'pg_fetch_result',
        'pg_fieldprtlen' => 'pg_field_prtlen',
        'pg_fieldisnull' => 'pg_field_is_null',
        'pg_freeresult' =>  'pg_free_result',
        'pg_getlastoid' =>  'pg_last_oid',
        'pg_locreate' =>    'pg_lo_create',
        'pg_lounlink' =>    'pg_lo_unlink',
        'pg_loopen' =>  'pg_lo_open',
        'pg_loclose' => 'pg_lo_close',
        'pg_loread' =>  'pg_lo_read',
        'pg_lowrite' => 'pg_lo_write',
        'pg_loreadall' =>   'pg_lo_read_all',
        'pg_loimport' =>    'pg_lo_import',
        'pg_loexport' =>    'pg_lo_export',
        'pg_setclientencoding' =>   'pg_set_client_encoding',
        'pg_clientencoding' =>  'pg_client_encoding',
        'png2wbmp' => 'imagebmp',
        'read_exif_data' => 'exif_read_data',
        'restore_include_path' => 'ini_restore("include_path")',
    ],
    // scan use of is_resource
    BreakScan::KEY_RESOURCE => [
        'socket_create',
        'socket_create_listen',
        'socket_accept',
        'socket_import_stream',
        'socket_addrinfo_connect',
        'socket_addrinfo_bind',
        'socket_wsaprotocol_info_import',
        'socket_addrinfo_lookup',
        'curl_init',
        'curl_multi_init',
        'curl_share_init',
        'enchant_broker_init',
        'enchant_broker_request_dict',
        'enchant_broker_request_pwl_dict',
        'imagecreate',
        'imagecreatefrombmp',
        'imagecreatefromgd2',
        'imagecreatefromgd2part',
        'imagecreatefromgd',
        'imagecreatefromgif',
        'imagecreatefromjpeg',
        'imagecreatefrompng',
        'imagecreatefromstring',
        'imagecreatefromwbmp',
        'imagecreatefromwebp',
        'imagecreatefromxbm',
        'imagecreatefromxpm',
        'openssl_x509_read',
        'openssl_csr_sign',
        'openssl_csr_new',
        'openssl_pkey_new',
        'msg_get_queue',
        'sem_get',
        'shm_attach',
        'shmop_open',
        'xml_parser_create',
        'xml_parser_create_ns',
        'inflate_init',
        'deflate_init',
        'openssl_x509_read',
        'openssl_csr_sign',
        'openssl_csr_new',
        'openssl_pkey_new',
        'msg_get_queue',
        'sem_get',
        'shm_attach',
        'shmop_open',
        'xml_parser_create',
        'xml_parser_create_ns',
        'inflate_init',
        'deflate_init',
    ],
    // list of magic method signature patterns
    BreakScan::KEY_MAGIC => [
        '__call'       => ['signature' => '__call(string $name, array $arguments): mixed',
                           'return' => 'mixed'],
        '__callStatic' => ['signature' => '__callStatic(string $name, array $arguments): mixed',
                           'return' => 'mixed'],
        '__clone'      => ['signature' => '__clone(): void',
                           'return' => 'void'],
        '__debugInfo'  => ['signature' => '__debugInfo(): ?array',
                           'return' => '\?array'],
        '__get'        => ['signature' => '__get(string $name): mixed',
                           'return' => 'mixed'],
        '__invoke'     => ['signature' => '__invoke(mixed $arguments): mixed',
                           'return' => 'mixed'],
        '__isset'      => ['signature' => '__isset(string $name): bool',
                           'return' => 'bool'],
        '__serialize'  => ['signature' => '__serialize(): array',
                           'return' => 'array'],
        '__set'        => ['signature' => '__set(string $name, mixed $value): void',
                           'return' => 'void'],
        '__set_state'  => ['signature' => '__set_state(array $properties): object',
                           'return' => 'object'],
        '__sleep'      => ['signature' => '__sleep(): array',
                           'return' => 'array'],
        '__unserialize'=> ['signature' => '__unserialize(array $data): void',
                           'return' => 'void'],
        '__unset'      => ['signature' => '__unset(string $name): void',
                           'return' => 'void'],
        '__wakeup'     => ['signature' => '__wakeup(): void',
                           'return' => 'void'],
    ],
    BreakScan::KEY_CALLBACK => [
        'ERR_CLASS_CONSTRUCT' => [
            'callback' => function ($contents) {
                $class = BreakScan::getKeyValue($contents, 'class', '{');
                if (empty($class)) return FALSE;
                return (stripos($contents, 'function __construct') === FALSE
                        && (stripos($contents, 'function ' . $class . '(')
                        || stripos($contents, 'function ' . $class . ' (')));
            },
            'msg' => 'WARNING: contains method same name as class but no __construct() method defined.  Can no longer use method with same name as the class as a constructor.'],
        'ERR_CONST_EXIT'      => [
            'callback' => function ($contents) {
                return (preg_match('/__construct.*?\{.*?(die|exit).*?}/im', $contents)
                        && strpos('__destruct', $contents));
            },
            'msg' => 'WARNING: __destruct() might not get called if "die()" or "exit()" used in __construct()'],
        'ERR_MATCH_KEYWORD'   => [
            'callback' => function ($contents) {
                return preg_match('/function\s+match(\s)?\(/', $contents);
            },
            'msg' => 'WARNING: "match" is now a reserved key word'],
        'ERR_DEFINE_THIRD_ARG'    => [
            'callback' => function ($contents) {
                $item = BreakScan::getKeyValue($contents, 'define(', ';');
                return (empty($item)) ? FALSE : stripos($item, 'TRUE');
            },
            'msg' => 'WARNING: the third argument to "define()" needs to be FALSE. Constants are now always case sensitive'],
        'ERR_ATTRIBUTES'    => [
            'callback' => function ($contents) {
                return preg_match('/\s#\[/', $contents);
            },
            'msg' => 'WARNING: comments that begin with "#[" are no longer allowed.  You should convert these into Attributes instead.'],
        'ERR_LOCALE_INDEPENDENCE'    => [
            'callback' => function ($contents) {
                return (stripos($contents, ' setlocale(') || strpos($contents, ' setlocale ('));
            },
            'msg' => 'WARNING: if you have a float-to-string typecast (implicit or explicit), the output will no longer be in the set locale.  Use "printf()", "number_format()" or the NumberFormatter class instead.'],
        'ERR_ASSERT_IN_NAMESPACE'    => [
            'callback' => function ($contents) {
                return (preg_match('/namespace.*?assert\s*\(/', $contents));
            },
            'msg' => 'WARNING: "assert()" is now a reserved function name, even when used inside a namespace.  You must rename this function to something else.'],
        'ERR_SPACES_IN_NAMESPACE'    => [
            'callback' => function ($contents) {
                if (strpos($contents, 'namespace') === FALSE) return 0;
                $namespace = BreakScan::getKeyValue($contents, 'namespace', ';');
                return (empty($namespace)) ? FALSE : strpos($namespace, ' ');
            },
            'msg' => 'WARNING: namespaces can no longer contain spaces in PHP 8.'],
        'ERR_REFLECTION_EXPORT'    => [
            'callback' => function ($contents) {
                return (preg_match('/Reflection.*?::export(\s)?\(/', $contents));
            },
            'msg' => 'WARNING: Reflection::export() has been removed.  Echo the Reflection object or use its "__toString()" method.'],
        'ERR_AT_SUPPRESS'    => [
            'callback' => function ($contents) {
                return preg_match('/\=\s*\@\w/', $contents);
            },
            'msg' => 'WARNING: using the "@" operator to suppress warnings no longer works in PHP 8.'],
        'ERR_PHP_ERRORMSG'    => [
            'callback' => function ($contents) {
                return strpos($contents, '$php_errormsg');
            },
            'msg' => 'WARNING: the "track_errors" php.ini directive is removed.  You can no longer rely upon "$php_errormsg".'],
        'ERR_ERROR_CONTEXT'    => [
            'callback' => function ($contents) {
                return strpos($contents, '$errorcontext');
            },
            'msg' => 'WARNING: the 5th argument $errorcontext, formerly passed to your customer error handler, is ignored in PHP 8.'],
    ],
];
