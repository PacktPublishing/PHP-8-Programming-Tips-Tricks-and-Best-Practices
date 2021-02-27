#!/bin/bash
echo "Initializing the PHP 7 Container ..."
mv -f /srv/www /srv/www.OLD
ln -sfv /repo /srv/www
chgrp apache /srv/www
chgrp -R apache /repo
chmod -R 775 /repo
lfphp --mysql --phpfpm --apache
