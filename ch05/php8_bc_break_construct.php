<?php
// /repo/ch05/php8_oop_bc_break_construct.php
// does not work in PHP 8

class Text
{
    public $fh = '';
    public const ERROR_FN = 'ERROR: file not found';
    public function text(string $fn)
    {
        if (!file_exists($fn))
            throw new Exception(self::ERROR_FN);
        $this->fh = new SplFileObject($fn, 'r');
    }
    public function getText()
    {
        return $this->fh->fpassthru();
    }
}

$fn   = __DIR__ . '/../sample_data/gettysburg.txt';
$text = new Text($fn);
echo $text->getText();
