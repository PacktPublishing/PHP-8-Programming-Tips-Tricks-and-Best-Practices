<?php
// /repo/ch12/php8_chat_test.php

// CLI usage:
// php php8_chat_test.php API_ENDPOINT NUM_ITERATIONS [--no-output]
// Example (no output):
// php php8_chat_test.php API_ENDPOINT NUM_ITERATIONS

if (!session_status() === PHP_SESSION_ACTIVE) session_start();

include __DIR__ . '/vendor/autoload.php';
use Chat\Http\Client;
use Chat\Generic\Constants;
use Laminas\Diactoros\Response\JsonResponse;

// init vars
$target   = $_GET['host']   ?? $argv[1] ?? $_SERVER['HTTP_HOST'] ?? 'http://localhost/ch12/php8_chat_ajax.php';
$num      = $_GET['num']    ?? $argv[2] ?? 100;   // number of iterations
$no_out   = $_GET['no_out'] ?? $argv[3] ?? 1;
$no_out   = (empty($no_out)) ? FALSE : TRUE;
$error    = '';
$start    = microtime(TRUE);
$response = 'Default';
$html     = !empty($_SERVER['REQUEST_URI']);
$list     = [];
$year     = date('Y');
$geo_db   = __DIR__ . '/../sample_data/geonames.db';
// get country info and put into an InfiniteIterator instance
$geonames = new PDO('sqlite:' . $geo_db);
$sql      = 'SELECT name,country_code,population FROM geonames';
$stmt     = $geonames->query($sql);
$data     = $stmt->fetchAll(PDO::FETCH_NUM);
$iter     = new ArrayIterator($data);
$info     = new InfiniteIterator($iter);
$info->rewind();
// get list of usernames
$users = Client::doGet($target . '?all=1') ?? [];
if (empty($users['data'])) exit('Error accessing user list');
foreach ($users['data'] as $value) {
    $list[] = $value['username'] ?? 'Unknown';
}
// pick random "from" user
$user = $list[array_rand($list)];
// reset messages table
$reset = Client::doDelete($target) ?? [];
if ($html) echo '<pre>';
for ($x = 0; $x < ((int) $num); $x++) {
    // post random data
    $date = sprintf('%4d-%02d-%02d %02d:%02d:%02d',
                   $year + ($x % 3), ($x % 12) + 1, ($x % 28) + 1,
                   ($x % 23), ($x % 59), ($x % 59));
    $row = $info->current();
    $data = [
        'from' => $user,
        'to'   => $list[array_rand($list)],
        'msg'  => implode(':', $row),
        'created' => $date
    ];
    // post message
    try {
        $result = Client::doPost($target, $data);
    } catch (Throwable $t) {
        error_log(__FILE__ . ':' . $t);
        $response = (new JsonResponse(['status' => 'fail', 'data' => $t]))->withStatus(500);
    }
    if ($result['status'] === 'success' && !empty($result['data'])) {
        ['from' => $from, 'to' => $to, 'msg' => $msg, 'created' => $date] = $result['data'];
        if (!$no_out) printf("%6d : %10s : %30s : %20s\n", $x, $to, $msg, $date);
    }
    $info->next();
}
echo "\nFrom User: $user\n";
echo "Elapsed Time: " . (microtime(TRUE) - $start) . "\n";
if ($html) echo '</pre>';
