<?php
// /repo/ch02/php8_sqlite_auth_admin.php
include __DIR__ . '/includes/auth_callback.php';
// Normally $user would come from $_SESSION information
// Here we simulate the user using $_GET
session_start();
$_SESSION['user'] = $argv[1] ?? 'admin';
echo '<pre>' . PHP_EOL;
$name = ['jclayton','mpaulovich','nrousseau','jporter'];
$email = ['unlikelysource.com','lfphpcloud.net','phptraining.net'];
shuffle($name);
shuffle($email);
try {
    $msg = sprintf(PATTERN, 'TABLE', 'CODE',  'ARGS', 'SESS');
    error_log($msg);
    $sqlite = new SQLite3(DB_FILE);
    $sqlite->setAuthorizer('auth_callback');
    $sql = 'INSERT INTO users VALUES (:id, :name, :email, :pwd);';
    $stmt = $sqlite->prepare($sql);
    if ($stmt) {
        $user_name = $name[0];
        $user_email = $name[0] . '@' . $email[0];
        $id = md5($user_email);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $user_name);
        $stmt->bindValue(':email', $user_email);
        $stmt->bindValue(':pwd', 'password');
        $result = $stmt->execute();
        $sql = 'SELECT * FROM users';
        $result = $sqlite->query($sql);
        printf("%-10s : %-10s\n", 'Name','Email');
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
            printf("%-10s : %-  10s\n",
                $row['user_name'],
                $row['user_email']);
    }
} catch (Throwable $e) {
    error_log(get_class($e) . ':' . $e->getMessage());
}
echo "\n</pre>";
