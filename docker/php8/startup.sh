#!/bin/bash
echo "Finishing Apache setup ..."
mv -f /srv/www /srv/www.OLD
ln -sfv /repo /srv/www
chown apache:apache /srv/www
chown -R apache:apache /repo
chmod -R 775 /repo
/etc/init.d/mysql start
/etc/init.d/phpfpm start
/etc/init.d/mysql start
lfphp --mysql --phpfpm --apache
