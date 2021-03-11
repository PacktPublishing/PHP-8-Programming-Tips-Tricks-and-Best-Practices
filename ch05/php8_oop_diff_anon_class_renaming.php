<?php
// /repo/ch05/php8_oop_diff_anon_class_renaming.php

// set up an iterator that filters filenames from the current directory
$iter = new DirectoryIterator(__DIR__);
$anon = new class ($iter) extends FilterIterator {
    public $search = '';
    public function accept() {
        return str_contains($this->current(), $this->search);
    }
};

// displays a list of all files containing "bc_break"
$anon->search = 'bc_break';
foreach ($anon as $fn) echo $fn . "\n";

// test inheritance
if ($anon instanceof OuterIterator)
    echo "This object implements OuterIterator\n";

// display class name
echo var_dump($anon);

