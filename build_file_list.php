<?php
// constants
if (!defined('FILE_LIST'))
    define('FILE_LIST', __DIR__ . '/sample_data/file_list.txt');
$dirIter = new RecursiveDirectoryIterator(__DIR__);
$iterIter = new RecursiveIteratorIterator($dirIter);
// create filter by category
$filt = new class ($iterIter) extends FilterIterator {
    public function accept() : bool
    {
        $fn = $this->key();
        $obj = $this->current();
        $ok = 0;
        $ok += (int) (strpos($fn, '/php7_') !== FALSE);
        $ok += (int) (strpos($fn, '/php8_') !== FALSE);
        $ok += (int) (strpos($fn, '/ch') !== FALSE);
        $ok += ($obj->getExtension() === 'php');
        return ($ok > 2);
    }
};
$list = [];
foreach ($filt as $name => $obj) {
    $shortName = str_replace(__DIR__, '', $name);
    $list[] = $shortName;
}
sort($list);
file_put_contents(FILE_LIST, implode("\n", $list));
