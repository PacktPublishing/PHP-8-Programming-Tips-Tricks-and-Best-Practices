<?php
// constants
define('COLS', 3);
define('SPACER', '<td>&nbsp;&nbsp;&nbsp;</td>');
define('FORMAT', '<td style="margin-right: 20px;"><a href="run.php?file=ch%02d/%s">%s</a></td>' . PHP_EOL);
// init vars
$flag = TRUE;
$iter = NULL;
$filt = NULL;
$phpMyAdmin = TRUE;
// output file list
if (empty($message)) $message = '';
if (empty($output)) {
	$output = '';
	$dirIter = new RecursiveDirectoryIterator(__DIR__);
	$iterIter = new RecursiveIteratorIterator($dirIter);
	// create filter by category
	$filt = new class ($iterIter) extends FilterIterator {
		public $cat = 'ch';
		public function accept() : bool
		{
			$fn = parent::current();
			$key = '/' . $this->cat . '/';
			return (strpos($fn, $key) && $fn->isFile());
		}
	};
	//echo __FILE__ . ':' . var_export(iterator_to_array($filt), TRUE); exit;
}
include __DIR__ . '/home.phtml';
