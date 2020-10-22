<?php
namespace Php7\Http;

use DOMDocument;
class TestData
{
	public static function redirect()
	{
		return '/';
	}
	public static function html()
	{
		return file_get_contents('https://loripsum.net/api/3/short/ul/bq/headers');
	}
	public static function json()
	{
		return json_decode(file_get_contents('http://api.unlikelysource.com/'), TRUE);
	}
	public static function xml()
	{
		$dom = new DOMDocument();
		$doc = $dom->loadHTML(self::html());
		return $doc->saveXML();
	}
	public static function pdf()
	{
		return __DIR__ . '/../../../sample_data/ipsum.pdf';
	}
}
