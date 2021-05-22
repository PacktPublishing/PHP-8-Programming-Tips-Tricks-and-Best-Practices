<?php
// /repo/ch09/php8_dom_changes.php
// moves "Topic X" from $doc1 to $doc2

// load both HTML files into DOM
$doc1 = new DomDocument();
$doc1->loadHTMLFile('dom_test_1.html');
$doc2 = new DomDocument();
$doc2->loadHTMLFile('dom_test_2.html');

// echo before
$h1 = $doc1->getElementsByTagName('h1')[0];
$h1->textContent = 'Doc 1 BEFORE';
$h2 = $doc2->getElementsByTagName('h1')[0];
$h2->textContent = 'Doc 2 BEFORE';
echo $doc1->saveHTML();
echo $doc2->saveHTML();

// extract topic X from doc 1
$topic = $doc1->getElementById('X');

// insert topic X into doc 2
$new = $doc2->importNode($topic);
$new->textContent= $topic->textContent;
$ul2  = $doc2->getElementById('ul_2');
$ul2->appendChild($new);

// remove topic X from doc 1
$ul1 = $doc1->getElementById('ul_1');
$ul1->removeChild($topic);

// echo after
$h1 = $doc1->getElementsByTagName('h1')[0];
$h1->textContent = 'Doc 1 AFTER';
$h2 = $doc2->getElementsByTagName('h1')[0];
$h2->textContent = 'Doc 2 AFTER';
echo $doc1->saveHTML();
echo $doc2->saveHTML();
