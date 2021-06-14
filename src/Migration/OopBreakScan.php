<?php
// /repo/src/Migration/OopBreakScan.php
declare(strict_types=1);
namespace Migration;
use ArrayIterator;
/**
 * Designed to run on PHP 7 or below
 * Looks for things that might break OOP code
 */
class OopBreakScan extends Base
{
    const ERR_MAGIC_SIGNATURE = 'WARNING: need to confirm magic method signature: ';
    const ERR_NAMESPACE       = 'WARNING: namespaces can no longer contain spaces in PHP 8.';
    const ERR_REMOVED         = 'WARNING: the following function has been removed: %s.  Use this instead: %s';

    const REMOVED_FUNCS = [
        'image2wbmp' => 'imagebmp',
        'png2wbmp' => 'imagebmp',
        'jpeg2wbmp' => 'imagebmp',
        'gmp_random', => 'gmp_random_range',
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
    ];
    /**
     * Check for removed functions
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public function scanRemovedFunctions(string $contents, array &$message) : bool
    {
        $found = 0;
        foreach (self::REMOVED_FUNCS as $func => $replace) {
            if ((strpos($contents, $func) !== FALSE)) {
                $message[] = sprintf(self::ERR_REMOVED, $fund, $replace);
                $found++;
            }
        }
        if ($found === 0)
            $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
    /**
     * Scan for spaces in namespace references
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public function scanSpacesInNamespace(string $contents, array &$message) : bool
    {
        if ($pos = stripos($contents, 'namespace') !== FALSE) {
            $pos += 9;  // offset for "namespace"
            $end = strpos($contents, ';', $pos);
            $test = trim(substr($contents, $pos, $end - $pos));
            if ((strpos($test, ' ') !== FALSE)) {
                $message[] = self::ERR_NAMESPACE;
                return TRUE;
            }
        }
        $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return FALSE;
    }
    /**
     * Scan for magic method signatures
     *
     * @param string $contents : PHP file contents
     * @param array $message   : return success or failure message
     * @return bool $found     : TRUE if a break was found
     */
    public function scanMagicSignatures(string $contents, array &$message) : bool
    {
        // bail out if no magic methods defined
        if (strpos($contents, 'function __') === FALSE) return FALSE;
        // list of signature patterns
        $list = [
            '__call'       => '__call(string $name, array $arguments): mixed',
            '__callStatic' => '__callStatic(string $name, array $arguments): mixed',
            '__clone'      => '__clone(): void',
            '__debugInfo'  => '__debugInfo(): ?array',
            '__get'        => '__get(string $name): mixed',
            '__invoke'     => '__invoke(mixed $arguments): mixed',
            '__isset'      => '__isset(string $name): bool',
            '__serialize'  => '__serialize(): array',
            '__set'        => '__set(string $name, mixed $value): void',
            '__set_state'  => '__set_state(array $properties): object',
            '__sleep'      => '__sleep(): array',
            '__unserialize'=> '__unserialize(array $data): void',
            '__unset'      => '__unset(string $name): void',
            '__wakeup'     => '__wakeup(): void',
        ];
        // break contents into ArrayIterator
        $iter = new ArrayIterator(explode("\n", $contents));
        // go line-by-line
        $found    = 0;
        while ($iter->valid()) {
            $line = $iter->current();
            // skip if not magic method function signature
            if (strpos($contents, 'function __') !== FALSE) {
                // extract method name
                $extract = '/(__\w+?).*?\(/';
                preg_match($extract, $line, $matches);
                $name = $matches[1] ?? 'XXX';
                $name = trim($name);
                // locate signature
                $confirm = $list[$name] ?? '';
                if ($confirm) {
                    // check 1st arg
                    if (strpos($line, '($') === FALSE
                        && strpos($confirm, '(string')
                        &&strpos($line, '(string') === FALSE) {
                        $message[] = self::ERR_MAGIC_SIGNATURE . $list[$name];
                        $found++;
                    }
                    // check 2nd arg (if any)
                    if (strpos($confirm, ', array')
                        && strpos($line, ', $') === FALSE
                        && strpos($line, ', array') !== FALSE) {
                        $message[] = self::ERR_MAGIC_SIGNATURE . $list[$name];
                        $found++;
                    }
                    // check return data type (if any)
                    if (strpos($line, ':') !== FALSE) {
                        // extract return data type from $confirm
                        $pos = strpos($confirm, ':');
                        $type = trim(substr($confirm, $pos));
                        // extract return data type from $line
                        $pos = strpos($line, ':');
                        $check = substr($line, $pos);
                        $check = str_replace('{', '', $check);
                        $check = trim($check);
                        if ($type !== $check) {
                            $message[] = self::ERR_MAGIC_SIGNATURE . $list[$name];
                            $found++;
                        }
                    }
                }
            }
            $iter->next();
        }
        if (!$found) $message[] = sprintf(Base::OK_PASSED, __FUNCTION__);
        return (bool) $found;
    }
}
