<?php
session_start();
include __DIR__ . '/vendor/autoload.php';
use Chat\Http\Client;
$error    = '';
$host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
$host     = (strpos($host, '8888')) ? 'localhost' : $host;
$target   = 'http://' . $host . '/ch12/php8_chat_ajax.php';
$user     = $_SESSION['user'] ?? '';
$response = 'Default';
// process POST
if ($_POST) {
    $user = $_POST['from'] ?? '';
    if ($user) $_SESSION['user'] = $user;
    $data = Client::doPost($target, $_POST);
}
// get list of usernames
$select = '<option value="">Choose</option>' . PHP_EOL;
$list = Client::doGet($target . '?all=1') ?? [];
if ($list) {
    foreach ($list['data'] as $row) {
        $name = $row['username'];
        $select .= '<option value="' . $name . '">'
                 . $name . '</option>' . PHP_EOL;
    }
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
<tr><th>From</th><td><select id="from" name="from"><?= $select ?></select><input type="text" id="user" /></td></tr>
<tr><th>To</th><td><select id="to" name="to"><?= $select ?></select></td></tr>
<tr><th>Message</th><td><textarea id="msg" name="msg" rows=4 cols=80></textarea></td></tr>
<tr><th>&nbsp;</th><td><button id="send" >Send</button></td></tr>
<tr><th>Status</th><td><div id="status"><?= $data['status'] ?? 'Unknown'; ?></div></td></tr>
<tr><th>&nbsp;</th>
    <td>
    <div id="polling">No Messages</div>
    </td>
</tr>
</table>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
function poll()
{
    var from = $('#user').val();
    var url ="<?= $target ?>" + "?from=" + from;
    $.get(url, function (data) { $('#polling').html(data); } );
    setTimeout( function () {poll()}, 5000);
}
$(document).ready(function () {
    $('#send').click( function () {
        $('#user').val($('#from').val());
        poll();
    });
});
</script>
</body>
</html>
