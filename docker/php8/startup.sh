#!/bin/bash
echo "Updating Composer packages ... "
cd /repo/ch10
composer install
cd /repo/ch12
composer install
cd /repo/test/phpunit9
composer install
echo "Finishing Apache setup ..."
mv -f /srv/www /srv/www.OLD
ln -sfv /repo /srv/www
chown apache:apache /srv/www
chgrp -R apache /repo
chmod -R 775 /repo
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start
lfphp --mysql --phpfpm --apache >/dev/null 2&>1
