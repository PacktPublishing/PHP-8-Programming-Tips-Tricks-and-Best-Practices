<?php
namespace Server\Display;

class Execute
{
	public function execPhp7(string $fullName)
	{
		$cmdTh = 'php7 --version';
		$cmdTd = 'php7 ' . $fullName;
		return $this->doExec($cmdTh, $cmdTd);
	}

	public function execPhp8(string $fullName)
	{
		$cmdTh = 'php8 --version';
		$cmdTd = 'php8 ' . $fullName;
		return $this->doExec($cmdTh, $cmdTd);
	}

	public function doExec(string $cmdTh, string $cmdTd)
	{
		try {
			$th = substr(shell_exec($cmdTh), 0, 9);
			$raw = shell_exec($cmdTd);
		} catch (Throwable $t) {
			$raw = get_class($t) . ':' . $t->getMessage();
		}
		$escaped = htmlspecialchars($td);
		return ['th' => $th, 'raw' => $raw, 'esc' => $escaped];
	}

	public function fileWithLineNumbers(string $fullName)
	{
		$output = '';
		$code = highlight_file($fullName, TRUE);
		$contents = explode('<br />', $code);
		$pattern = '<span style="color:gray;">%02d</span>   %s<br />';
		foreach ($contents as $index => $line)
			$output .= sprintf($pattern, $index + 1, $line);
		return $output;
	}

	public function render(string $fullName)
	{
		$output = '';
		if (!file_exists($fullName)) {
			$output = 'File not found: ' . $fullName;
		} else {
			$code = $this->fileWithLineNumbers($fullName);
			$output .= '<section id="services" class="bg-light">'
					 . '<div class="container">'
					 . '<h2>Executed File</h2>'
					 . $code
					 . '</div>'
					 . '</section>';
			if (strpos($fullName, 'php7') !== FALSE) {
				$result = $this->execPhp7($fullName);
			} else {
				$result = $this->execPhp8($fullName);
			}
			$output .= '<section id="contact">'
					 . '<div class="container">'
					 . '<div class="row">'
					 . '<div class="col-md-12">'
					 . '<h2>' . $result['th'] . '</h2>'
					 . '<hr><b>Raw Output</h2></b><hr><br>'
					 . '<!-- RAW OUTPUT -->'
					 . $result['raw']
					 . '</div>'
					 . '</div>'
					 . '<!-- RAW OUTPUT -->'
					 . '<div class="row">'
					 . '<div class="col-md-12">'
					 . '<hr><b>Escaped Output</b><hr><br>'
					 . '<!-- ESCAPED OUTPUT -->'
					 . $result['esc']
					 . '<!-- ESCAPED OUTPUT -->'
					 . '</div>'
					 . '</div>'
					 . '</div>'
					 . '</div>'
					 . '</section>';
		}
		return $output;
	}
}
