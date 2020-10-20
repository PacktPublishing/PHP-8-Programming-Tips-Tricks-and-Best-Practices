<?php
namespace Php7\Http;

class Response
{
	public static function redirectResponse(string $url)
	{
		self::sendResponse(
			NULL,
			'Location: ' . $url,
		);
		exit;
	}
	public static function htmlResponse(string $body)
	{
		self::sendResponse(
			$body,
			'Content-Type: text/html'
		);
	}
	public static function jsonResponse(array $body)
	{
		self::sendResponse(
			json_encode($body),
			'Content-Type: application/json'
		);
	}
	public static function pdfResponse($pdf_file)
	{
		self::sendResponse(
			file_get_contents($pdf_file),
			'Content-Type: application/pdf',
			'Content-Disposition: attachment; '
			. 'filename="' . basename($pdf_file) . '"'
		);
	}
	public static function sendResponse($body, ...$headers)
	{
		foreach ($headers as $item) header($item);
		echo $body;
	}
}
