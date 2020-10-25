<?php
namespace Server\Display;

class Execute
{
	public function fileWithLineNumbers(string $fullName)
	{
		$output = '';
		$code = highlight_file($fullName, TRUE);
		$contents = explode('<br />', $code);
		$pattern = '<span style="color:gray;font-size:11pt;font-family:courier;">%02d</span>   %s<br />';
		foreach ($contents as $index => $line)
			$output .= sprintf($pattern, $index + 1, $line);
		return $output;
	}

	public function reveal_code(string $fullName, string $runFile)
	{
		$output = '';
		if (!file_exists($fullName)) {
			$output = 'File not found: ' . $fullName;
		} else {
			// produce formatted output
			$code = $this->fileWithLineNumbers($fullName);
			$output .= '<section id="services" class="bg-light">'
					 . '<div class="container">'
					 . '<h2>Execute File: <a target="_blank" href="' . $runFile . '">' . $runFile . '</a></h2>'
					 . $code
					 . '</div>'
					 . '</section>';
		}
		return $output;
	}

	public function render(string $fullName)
	{
		$output = '';
		if (!file_exists($fullName)) {
			$output = 'File not found: ' . $fullName;
		} else {
			// execute code
			ob_start();
			include $fullName;
			$contents = ob_get_contents();
			ob_end_clean();
			// produce formatted output
			$code = $this->fileWithLineNumbers($fullName);
			$output .= '<section id="services" class="bg-light">'
					 . '<div class="container">'
					 . '<h2>Executed File</h2>'
					 . $code
					 . '</div>'
					 . '</section>';
			$output .= '<section id="contact">'
					 . '<div class="container">'
					 . '<div class="row">'
					 . '<div class="col-md-12">'
					 . '<h2>PHP ' . PHP_VERSION . '</h2>'
					 . '<hr><b>Raw Output</h2></b><hr><br>'
					 . '<!-- RAW OUTPUT -->'
					 . $contents
					 . '</div>'
					 . '</div>'
					 . '<!-- RAW OUTPUT -->'
					 . '<div class="row">'
					 . '<div class="col-md-12">'
					 . '<hr><b>Escaped Output</b><hr><br>'
					 . '<!-- ESCAPED OUTPUT -->'
					 . htmlspecialchars($contents)
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
