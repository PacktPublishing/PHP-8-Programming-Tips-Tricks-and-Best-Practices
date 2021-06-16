<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Code for displaying server selection
 *
 * @package PhpMyAdmin
 */

/**
 * Renders the server selection in list or selectbox form, or option tags only
 *
 * @param boolean $not_only_options whether to include form tags or not
 * @param boolean $omit_fieldset    whether to omit fieldset tag or not
 *
 * @return string
 */
function PMA_selectServer($not_only_options, $omit_fieldset)
{
    $retval = '';

    // Show as list?
    if ($not_only_options) {
        $list = $GLOBALS['cfg']['DisplayServersList'];
        $not_only_options =! $list;
    } else {
        $list = false;
    }

    if ($not_only_options) {
        $retval .= '<form method="post" action="'
            . PMA\libraries\Util::getScriptNameForOption(
                $GLOBALS['cfg']['DefaultTabServer'], 'server'
            )
            . '" class="disableAjax">';

        if (! $omit_fieldset) {
            $retval .= '<fieldset>';
        }
        $retval .= '<label for="select_server">'
            . __('Current server:') . '</label> ';

        $retval .= '<select name="server" id="select_server" class="autosubmit">';
        $retval .= '<option value="">(' . __('Servers') . ') ...</option>' . "\n";
    } elseif ($list) {
        $retval .= __('Current server:') . '<br />';
        $retval .= '<ul id="list_server">';
    }

    foreach ($GLOBALS['cfg']['Servers'] as $key => $server) {
        if (empty($server['host'])) {
            continue;
        }

        if (!empty($GLOBALS['server']) && (int) $GLOBALS['server'] === (int) $key) {
            $selected = 1;
        } else {
            $selected = 0;
        }
        if (!empty($server['verbose'])) {
            $label = $server['verbose'];
        } else {
            $label = $server['host'];
            if (!empty($server['port'])) {
                $label .= ':' . $server['port'];
            }
        }
        if (! empty($server['only_db'])) {
            if (! is_array($server['only_db'])) {
                $label .= ' - ' . $server['only_db'];
                // try to avoid displaying a too wide selector
            } elseif (count($server['only_db']) < 4) {
                $label .= ' - ' . implode(', ', $server['only_db']);
            }
        }
        if (!empty($server['user']) && $server['auth_type'] == 'config') {
            $label .= '  (' . $server['user'] . ')';
        }

        if ($list) {
            $retval .= '<li>';
            if ($selected) {
                $retval .= '<strong>' . htmlspecialchars($label) . '</strong>';
            } else {

                $retval .= '<a class="disableAjax item" href="'
                    . PMA\libraries\Util::getScriptNameForOption(
                        $GLOBALS['cfg']['DefaultTabServer'], 'server'
                    )
                    . PMA_URL_getCommon(array('server' => $key))
                    . '" >' . htmlspecialchars($label) . '</a>';
            }
            $retval .= '</li>';
        } else {
            $retval .= '<option value="' . $key . '" '
                . ($selected ? ' selected="selected"' : '') . '>'
                . htmlspecialchars($label) . '</option>' . "\n";
        }
    } // end while

    if ($not_only_options) {
        $retval .= '</select>';
        if (! $omit_fieldset) {
            $retval .= '</fieldset>';
        }
        $retval .= '</form>';
    } elseif ($list) {
        $retval .= '</ul>';
    }

    return $retval;
}
