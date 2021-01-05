<?php
namespace Php7\Http;

class TestData
{
	const HTML_SRC = __DIR__ . '/../../../sample_data/html_src.html';
	public static function redirect()
	{
		return '/';
	}
	public static function html()
	{
		$wrapper  = file_get_contents(self::HTML_SRC);
		$contents = file_get_contents('https://loripsum.net/api/3/short/ul/bq/headers');
		return str_replace('%%CONTENTS%%', $contents, $wrapper);
	}
	public static function json()
	{
		return json_decode(file_get_contents('http://api.unlikelysource.com/'), TRUE);
	}
	public static function pdf()
	{
		return __DIR__ . '/../../../sample_data/ipsum.pdf';
	}
}
