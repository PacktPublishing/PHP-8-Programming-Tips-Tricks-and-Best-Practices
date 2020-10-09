<?php
define('EXAMPLES', 'examples');

function execPhp7($fullName)
{
    $cmdTh = 'php7 --version';
    $cmdTd = 'php7 ' . $fullName;
    return doExec($cmdTh, $cmdTd);
}

function execPhp8($fullName)
{
    $cmdTh = 'php8 --version';
    $cmdTd = 'php8 ' . $fullName;
    return doExec($cmdTh, $cmdTd);
}

function doExec($cmdTh, $cmdTd)
{
    try {
        $th = substr(shell_exec($cmdTh), 0, 9);
        $td = shell_exec($cmdTd);
    } catch (Throwable $t) {
        $td = get_class($t) . ':' . $t->getMessage();
    }
    $escaped = htmlspecialchars($td);
    return ['th' => $th, 'td' => $td, 'esc' => $escaped];
}

function fileWithLineNumbers($fullName)
{
	$output = '';
    $code = highlight_file($fullName, TRUE);
    $contents = explode('<br />', $code);
    $pattern = '<span style="color:gray;">%02d</span>   %s<br />';
    foreach ($contents as $index => $line)
		$output .= sprintf($pattern, $index + 1, $line);
	return $output;
}

$runFile  = (isset($_GET['file'])) ? basename($_GET['file']) : '';
$fullName = str_replace('//', '/', __DIR__ . '/' . EXAMPLES . '/' . $runFile);
$output   = '';
if (file_exists($fullName)) {
    $code = fileWithLineNumbers($fullName);
	$output .= <<<EOT
  <section id="services" class="bg-light">
    <div class="container">
	  <h2>Executed File</h2>
	  $code
    </div>
  </section>
EOT;
	$php7 = execPhp7($fullName);
	$php8 = execPhp8($fullName);
    $output .= <<<EOT
  <section id="contact">
    <div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>{$php7['th']}</h2>
				<br><b>Raw Output</h2></b>
				<pre>{$php7['td']}</pre><br>
			</div>
			<div class="col-md-6">
				<h2>{$php8['th']}</h2>
				<br><b>Raw Output</b><br>
				<pre>{$php8['td']}</pre><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<b>Escaped Output</b><br>
				<pre>{$php7['esc']}</pre>
			</div>
			<div class="col-md-6">
				<b>Escaped Output</b><br>
				<pre>{$php8['esc']}</pre>
			</div>
		</div>
    </div>
  </section>

EOT;
}
include __DIR__ . '/index.php';
