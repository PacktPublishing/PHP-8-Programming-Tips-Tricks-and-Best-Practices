#!/bin/bash
DIR=`pwd`
TOOLS_DIR=$DIR/vendor/phpcl/lfc_tools
LFC_DIR=$DIR/vendor/linuxforphp/linuxforcomposer/bin
LFC_PID=$DIR/vendor/composer
export USAGE="Usage: init.sh up|down|build|init|shell [arg]"
export CONTAINER="php8_tips"
export INIT=0
if [[ -z "$1" ]]; then
	echo $USAGE
	exit 1
elif [[ "$1" = "up" ]]; then
	docker-compose up -d $2
	INIT=1
elif [[ "$1" = "down" ]]; then
	docker-compose down
elif [[ "$1" = "build" ]]; then
	docker-compose build $2
elif [[ "$1" = "init" ]]; then
	INIT=1
elif [[ "$1" = "shell" ]]; then
	docker exec -it $CONTAINER /bin/bash
else
	echo $USAGE
	exit 1
fi
if [[ "$INIT" = 1 ]]; then
	docker exec $CONTAINER /bin/bash -c "/etc/init.d/mysql start"
	docker exec $CONTAINER /bin/bash -c "/etc/init.d/php-fpm start"
	docker exec $CONTAINER /bin/bash -c "/etc/init.d/httpd start"
	docker exec $CONTAINER /bin/bash -c "mv -fv /srv/www /srv/www.OLD"
	docker exec $CONTAINER /bin/bash -c "ln -sfv /repo /srv/www"
	docker exec $CONTAINER /bin/bash -c "chgrp apache /srv/www"
	docker exec $CONTAINER /bin/bash -c "chgrp -R apache /repo"
	docker exec $CONTAINER /bin/bash -c "chmod -R 775 /repo"
fi
exit 0
