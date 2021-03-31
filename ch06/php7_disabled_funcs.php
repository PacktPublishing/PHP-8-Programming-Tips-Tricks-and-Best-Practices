<?php
// /repo/ch06/php7_disabled_funcs.php
// You need to add the following to your php.ini file:
// disable_functions=system

// this should now not work
echo system('ls -l');

