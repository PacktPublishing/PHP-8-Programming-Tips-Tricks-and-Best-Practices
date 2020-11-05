<?php
// /repo/ch02/includes/auth_callback.php
define('DB_FILE', '/tmp/sqlite.db');
define('PATTERN', '%-8s | %4s | %-28s | %-15s');
define('DEFAULT_TABLE', 'Unknown');
define('DEFAULT_USER', 'guest');
define('ACL' , [
    // user => [table => rights, table => rights, etc.]
    'admin' => [
        'users' => [SQLite3::READ, SQLite3::SELECT, SQLite3::INSERT, SQLite3::UPDATE, SQLite3::DELETE],
        'geonames' => [SQLite3::READ, SQLite3::SELECT, SQLite3::INSERT, SQLite3::UPDATE, SQLite3::DELETE],
    ],
    'guest' => [
        'geonames' => [SQLite3::READ, SQLite3::SELECT],
    ],
]);
/**
 * Defines a callback to be used with SQLite::setAuthorizer()
 * For a full list of Action Codes passed to this callback
 * See: (see https://www.sqlite.org/c3ref/c_alter_table.html)
 *
 * @param int $code : SQLlite3 action code
 * @param array $args : 1 to 4 additional arguments
 */
function auth_callback(int $code, ...$args)
{
    $status = SQLite3::DENY;
    $table  = DEFAULT_TABLE;
    if ($code === SQLite3::SELECT) {
        $status = SQLite3::OK;
    } else {
        if (!empty($args[0])) {
            $table = $args[0];
        } elseif (!empty($_SESSION['table'])) {
            $table = $_SESSION['table'];
        }
        $user  = $_SESSION['user'] ?? DEFAULT_USER;
        // check to see if user is listed
        if (!empty(ACL[$user])) {
            // check to see if user is assigned to this table
            if (!empty(ACL[$user][$table])) {
                // check to see if code is allowed for this user and table
                if (in_array($code, ACL[$user][$table])) {
                    $status = SQLite3::OK;
                }
            }
        }
    }
    $message = sprintf(PATTERN, $table, (string) $code, implode(':', $args), implode(':', $_SESSION));
    error_log($message);
    $_SESSION['table'] = $table;
    return $status;
};
