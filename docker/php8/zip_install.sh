#!/usr/bin/env bash
# Usage: zip_install.sh VERSION
if [[ -z "$1" ]]; then
    export VER=1.19.2
else
    export VER=$1
fi
cd /tmp
wget http://pecl.php.net/get/zip-$VER.tgz
tar xvfz zip-$VER.tgz
cd zip-$VER
phpize
./configure
make
make install
echo "extension=zip">>/etc/php.ini
cd /tmp
rm -rf zip-$VER
rm zip-$VER.tgz
if [[ $? -gt 0 ]]; then
    echo -e "\nZip Extension Installation ERROR!  Aborting!\n"
    exit 1
fi
/etc/init.d/mysql restart
/etc/init.d/php-fpm restart
/etc/init.d/httpd restart
echo -e "\nZip Extension  Installation DONE!\n"
cd
