#!/bin/bash
/etc/init.d/mysql start
/etc/init.d/phpfpm start
/etc/init.d/mysql start
lfphp --mysql --phpfpm --apache >/dev/null 2&>1
