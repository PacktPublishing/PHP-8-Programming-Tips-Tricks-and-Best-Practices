#!/bin/bash
echo "Installing 3rd party software ..."
cd /repo
rm -f composer.phar
wget https://getcomposer.org/download/latest-stable/composer.phar
php composer.phar update
echo "Finishing Apache setup ..."
mv -f /srv/www /srv/www.OLD
ln -sfv /repo /srv/www
chown apache:apache /srv/www
chgrp -R apache /repo
chmod -R 775 /repo
/etc/init.d/mysql start
/etc/init.d/phpfpm start
/etc/init.d/mysql start
lfphp --mysql --phpfpm --apache  </dev/null >/dev/null 2&>1 &
