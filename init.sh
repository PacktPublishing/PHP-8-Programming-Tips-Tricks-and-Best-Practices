#!/bin/bash
DIR=`pwd`
TOOLS_DIR=$DIR/vendor/phpcl/lfc_tools
LFC_DIR=$DIR/vendor/linuxforphp/linuxforcomposer/bin
LFC_PID=$DIR/vendor/composer
export USAGE="Usage: init.sh up|down|build|restore_db|init|shell [7|8]"
export CONTAINER7="php8_tips_php7"
export CONTAINER8="php8_tips_php8"
export INIT=0
if [[ -z "$1" ]]; then
	echo $USAGE
	exit 1
elif [[ "$1" = "up" ]]; then
	docker-compose up -d $2
	INIT=1
elif [[ "$1" = "down" ]]; then
	docker exec $CONTAINER7 /bin/bash -c 'mysqldump -uroot -e php8_tips > /repo/backup/php8_tips_php7.sql'
	docker exec $CONTAINER8 /bin/bash -c 'mysqldump -uroot -e php8_tips > /repo/backup/php8_tips_php8.sql'
	docker-compose down
elif [[ "$1" = "build" ]]; then
	docker-compose build $2
elif [[ "$1" = "restore_db" ]]; then
	echo "Restoring sample database ..."
	docker exec $CONTAINER7 /bin/bash -c 'mysql -uroot -e "SOURCE /repo/backup/php8_tips_php7.sql;" php8_tips'
	docker exec $CONTAINER8 /bin/bash -c 'mysql -uroot -e "SOURCE /repo/backup/php8_tips_php8.sql;" php8_tips'
elif [[ "$1" = "init" ]]; then
	INIT=1
elif [[ "$1" = "shell" ]]; then
	if [[ -z "$2" ]]; then
		echo "You need to specify either 7 or 8"
		echo $USAGE
		exit 1
	elif [[ "$2" = "7" ]]; then
		docker exec -it $CONTAINER7 /bin/bash
	else
		docker exec -it $CONTAINER8 /bin/bash
	fi
else
	echo $USAGE
	exit 1
fi
if [[ "$INIT" = 1 ]]; then
	echo "Initializing the PHP 7 Container ..."
	docker exec $CONTAINER7 /bin/bash -c "/etc/init.d/mysql start"
	docker exec $CONTAINER7 /bin/bash -c "/etc/init.d/php-fpm start"
	docker exec $CONTAINER7 /bin/bash -c "/etc/init.d/httpd start"
	docker exec $CONTAINER7 /bin/bash -c "mv -f /srv/www /srv/www.OLD"
	docker exec $CONTAINER7 /bin/bash -c "ln -sfv /repo /srv/www"
	docker exec $CONTAINER7 /bin/bash -c "chgrp apache /srv/www"
	docker exec $CONTAINER7 /bin/bash -c "chgrp -R apache /repo"
	docker exec $CONTAINER7 /bin/bash -c "chmod -R 775 /repo"
	docker exec $CONTAINER7 /bin/bash -c 'mysql -uroot -e "SOURCE /repo/backup/php8_tips_php7.sql;" php8_tips'
	echo "Initializing the PHP 8 Container ..."
	docker exec $CONTAINER8 /bin/bash -c "/etc/init.d/mysql start"
	docker exec $CONTAINER8 /bin/bash -c "/etc/init.d/php-fpm start"
	docker exec $CONTAINER8 /bin/bash -c "/etc/init.d/httpd start"
	docker exec $CONTAINER8 /bin/bash -c "mv -f /srv/www /srv/www.OLD"
	docker exec $CONTAINER8 /bin/bash -c "ln -sfv /repo /srv/www"
	docker exec $CONTAINER8 /bin/bash -c "chgrp apache /srv/www"
	docker exec $CONTAINER8 /bin/bash -c "chgrp -R apache /repo"
	docker exec $CONTAINER8 /bin/bash -c "chmod -R 775 /repo"
	docker exec $CONTAINER8 /bin/bash -c 'mysql -uroot -e "SOURCE /repo/backup/php8_tips_php8.sql;" php8_tips'
fi
exit 0
