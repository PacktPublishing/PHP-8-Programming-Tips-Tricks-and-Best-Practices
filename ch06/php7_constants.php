<?php
// /repo/ch06/php7_constants.php

define('THIS_WORKS', 'This works');
define('Mixed_Case', 'Mixed Case Works');
define('DOES_THIS_WORK', 'Does this work?', TRUE);
echo __LINE__ . ':' . THIS_WORKS . "\n";
echo __LINE__ . ':' . Mixed_Case . "\n";
echo __LINE__ . ':' . DOES_THIS_WORK . "\n";
echo __LINE__ . ':' . Does_This_Work . "\n";
