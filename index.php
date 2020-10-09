<?php
// constants
if (!defined('EXAMPLES')) define('EXAMPLES', 'examples');
define('COLS', 3);
define('SPACER', '<td>&nbsp;&nbsp;&nbsp;</td>');
define('FORMAT', '<td style="margin-right: 20px;"><a href="run.php?file=%s">%s</a></td>' . PHP_EOL);
// init vars
$flag = TRUE;
$iter = NULL;
$filt = NULL;
$path = str_replace('//', '/', __DIR__ . '/' . EXAMPLES);
$categories = [
	'oop'  => 'OOP PHP',
	'proc' => 'Procedural PHP',
	'ext'  => 'PHP Extensions',
	'cool' => 'Cool Stuff',
	'imp'  => 'Improvements',
	'error'  => 'Error Handling',
	'dep'  => 'Deprecations',
	'lab' => 'Labs',
];
$phpMyAdmin = TRUE;
// output file list
if (empty($message)) $message = '';
if (empty($output)) {
	$output = '';
	$iter   = new ArrayIterator(glob($path . '/*.php'));
	$iter->asort();
	// create filter by category
	$filt = new class ($iter) extends FilterIterator {
		public $cat = 'cool';
		public function accept() : bool
		{
			$fn = parent::current();
			$key = '_' . $this->cat . '_';
			return (strpos($fn, $key));
		}
	};
}
// disable phpMyAdmin for demo site
if (strpos($_SERVER['HTTP_HOST'], 'dougbiereretistacom3.linuxforphp.com')) {
	$phpMyAdmin = FALSE;
	if (stripos($_SERVER['REQUEST_URI'], 'phpmyadmin') !== FALSE) {
		header('Location: /');
		exit;
	}
}
include __DIR__ . '/home.phtml';
