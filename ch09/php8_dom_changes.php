<?php
// /repo/ch09/php8_dom_changes.php
// moves "Topic X" from $doc1 to $doc2

// load both HTML files into DOM
$doc1 = new DomDocument();
$doc2 = new DomDocument();
$doc1->loadHTMLFile('dom_test_1.html');
$doc2->loadHTMLFile('dom_test_2.html');

// extract topic X from doc 1
$topic = $doc1->getElementById('X');

// insert topic X into doc 2
$new = $doc2->importNode($topic);
$new->textContent= $topic->textContent;
$main = $doc2->getElementById('content');
$main->append($new);

// remove topic X from doc 1
$topic->remove();

// echo after
echo $doc1->saveHTML();
echo $doc2->saveHTML();

// last element of main
echo "\nLast Topic in Doc 2: ";
echo $main->lastElementChild->textContent . "\n";
