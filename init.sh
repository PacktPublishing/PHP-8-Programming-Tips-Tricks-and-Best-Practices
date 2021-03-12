#!/bin/bash
DIR=`pwd`
export USAGE="Usage: init.sh up|down|build|restore_db|init|shell [7|8]"
export CONTAINER7="php8_tips_php7"
export CONTAINER8="php8_tips_php8"
export INIT=0
if [[ -z "$1" ]]; then
    echo $USAGE
    exit 1
elif [[ "$1" = "up" ]]; then
    docker-compose up -d $2
elif [[ "$1" = "down" ]]; then
    docker-compose down
    sudo chown -R $USER:$USER *
    sudo chown -R $USER:$USER .*
elif [[ "$1" = "build" ]]; then
    docker-compose build $2
elif [[ "$1" = "restore_db" ]]; then
    RESTORE_DB=1
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
exit 0
