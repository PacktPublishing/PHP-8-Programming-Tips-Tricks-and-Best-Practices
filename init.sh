#!/bin/bash
DIR=`pwd`
export USAGE="Usage: init.sh up|down|build|ls|init|shell [7|8]"
export CONTAINER7="php8_tips_php7"
export CONTAINER8="php8_tips_php8"
export INIT=0
if [[ -z "$1" ]]; then
    echo $USAGE
    exit 1
elif [[ "$1" = "up" ||  "$1" = "start" ]]; then
    docker-compose up -d $2
elif [[ "$1" = "down" ||  "$1" = "stop" ]]; then
    docker-compose down
    sudo chown -R $USER:$USER *
    sudo chown -R $USER:$USER .*
    rm 1
elif [[ "$1" = "build" ]]; then
    docker-compose build $2
elif [[ "$1" = "ls" ]]; then
    docker container ls
elif [[ "$1" = "init" ]]; then
        docker exec $CONTAINER7 /bin/bash -c "/etc/init.d/mysql restart"
        docker exec $CONTAINER7 /bin/bash -c "/etc/init.d/php-fpm restart"
        docker exec $CONTAINER7 /bin/bash -c "/etc/init.d/httpd restart"
        docker exec $CONTAINER8 /bin/bash -c "/etc/init.d/mysql restart"
        docker exec $CONTAINER8 /bin/bash -c "/etc/init.d/php-fpm restart"
        docker exec $CONTAINER8 /bin/bash -c "/etc/init.d/httpd restart"
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
exit 0
