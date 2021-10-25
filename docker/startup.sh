#!/bin/bash
echo "Finishing Apache setup ..."
mv -f /srv/www /srv/www.OLD
ln -sfv /repo /srv/www
chown apache:apache /srv/www
chown -R apache:apache /repo
chmod -R 775 /repo
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start
lfphp --mysql --phpfpm --apache
