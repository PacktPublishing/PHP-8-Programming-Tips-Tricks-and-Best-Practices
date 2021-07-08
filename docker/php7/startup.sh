#!/bin/bash
echo "Updating phpunit ..."
cd /repo/test/phpunit5
composer install
echo "Finishing Apache setup ..."
mv -f /srv/www /srv/www.OLD
ln -sfv /repo /srv/www
chown apache:apache /srv/www
chgrp -R apache /repo
chmod -R 775 /repo
/etc/init.d/mysql start
/etc/init.d/phpfpm start
/etc/init.d/mysql start
lfphp --mysql --phpfpm --apache >/dev/null 2&>1
