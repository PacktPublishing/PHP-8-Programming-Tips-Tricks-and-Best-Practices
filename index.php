<?php
// constants
define('COLS', 3);
define('FILE_LIST', __DIR__ . '/sample_data/file_list.txt');
// init vars
$flag = TRUE;
$iter = NULL;
$filt = NULL;
$phpMyAdmin = TRUE;
$pattern = '!/ch\d{2}/php!S';
$col_class = 'col-md-'
           . (string) ((int) 12 / COLS);
$vers = (PHP_VERSION[0] == '8') ? 'php8' : 'php7';
// output file list
if (empty($message)) $message = '';
if (empty($output)) {
    $output = '';
    if (!file_exists(FILE_LIST)) include __DIR__ . '/build_file_list.php';
    $iter = new ArrayIterator(file(FILE_LIST));
    $filt = new class ($iter, $vers) extends FilterIterator {
        public $vers = '';
        public function __construct($iter, $vers)
        {
            parent::__construct($iter);
            $this->vers = $vers;
        }
        public function accept()
        {
            return (bool) strpos($this->current(), $this->vers);
        }
    };
    $filt->rewind();
}
include __DIR__ . '/home.phtml';
