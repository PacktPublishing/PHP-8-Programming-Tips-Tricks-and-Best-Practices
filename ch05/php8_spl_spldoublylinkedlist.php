<?php
// /repo/ch05/php8_spl_spldoublylinkedlist.php

// define SplDoublyLinkedList + a show() method
$double = new class() extends SplDoublyLinkedList
{
    public function show(int $mode)
    {
        $this->setIteratorMode($mode);
        $this->rewind();
        while ($item = $this->current()) {
            echo $item . '. ';
            $this->next();
        }
    }
};

// insert values
$item = ['Person', 'Woman', 'Man', 'Camera', 'TV'];
foreach ($item as $key => $value)
    // this works in PHP 7 or PHP 8
    $double->push($value);

// display results forward
$forward = SplDoublyLinkedList::IT_MODE_FIFO
         | SplDoublyLinkedList::IT_MODE_KEEP;
echo "**************** Foward ********************\n";
$double->show($forward);

// display results in reverse
$reverse = SplDoublyLinkedList::IT_MODE_LIFO
         | SplDoublyLinkedList::IT_MODE_KEEP;
echo "\n\n**************** Reverse ********************\n";
$double->show($reverse);
echo "\n";
