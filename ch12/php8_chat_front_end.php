<?php
session_start();
$error    = '';
$host     = $_SERVER['HTTP_HOST'];
$target   = 'http://' . $host . '/ch12/php8_chat_ajax.php';
$user     = $_SESSION['user'] ?? '';
$response = 'Default';
if ($_POST) {
    $user = $_POST['from'] ?? '';
    $_SESSION['user'] = $user;
    $headers = [
        'Accept: text/html',
        'Content-type: application/x-www-form-urlencoded',
    ];
    $opts = [
        'http' => [
            'method'  => 'POST',
            'header'  => implode("\r\n", $headers),
            'content' => http_build_query($_POST)
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($target, FALSE, $context);
    $data = json_decode($response, TRUE);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Unlikely Chat</title>
</head>
<body>
<form method="post" action="#">
<table>
<tr><th>From</th><td><input id="from" type="text" name="from" value="<?= $user ?>" /></td></tr>
<tr><th>To</th><td><input id="to" type="text" name="to" /></td></tr>
<tr><th>Message</th><td><textarea id="msg" name="msg" rows=4 cols=80></textarea></td></tr>
<tr><th>&nbsp;</th><td><button id="send" >Send</button></td></tr>
<tr><th>Status</th><td><div id="status"><?= $data['status'] ?? 'Unknown'; ?></div></td></tr>
<tr><th>&nbsp;</th>
    <td>
    <?php if (!empty($data['data'])) : ?>
    <table>
    <tr><th>From</th><th>To</th><th>Message</th></tr>
        <?php foreach ($data['data'] as $row) : ?>
        <tr>
        <td><?= $row['user_from'] ?? '' ?></td>
        <td><?= $row['user_to'] ?? '' ?></td>
        <td><?= $row['msg'] ?? '' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else : ?>
    No Messages
    <?php endif; ?>
    </td>
</tr>
</table>
</form>
</body>
</html>
