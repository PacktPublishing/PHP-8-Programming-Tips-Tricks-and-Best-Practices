<?php
// /repo/ch08/php7_track_errors.php

ini_set('track_errors', 1);
@strpos();
echo $php_errormsg . "\n";
echo "OK\n";
