@echo off
SET USAGE="Usage: init.sh up|down|build|ls|init|shell [7|8]"
SET CONTAINER7="php8_tips_php7"
SET CONTAINER8="php8_tips_php8"
SET INIT=0

IF "%~1"=="" GOTO :done

IF "%1"=="up" OR "%1"=="start" GOTO :up
GOTO :opt2
:up
docker-compose up -d %2
GOTO:EOF

:opt2
IF "%1" =="down" OR  "%1"=="stop" GOTO :down
GOTO :opt3
:down
docker-compose down
takeown /R /F *
GOTO:EOF

:opt3
IF "%1"=="build" GOTO :build
GOTO :opt4
:build
docker-compose build %2
GOTO:EOF

:opt4
IF "%1"=="ls" GOTO :ls
GOTO :opt5
:ls
docker container ls
GOTO:EOF

:opt5
IF "%1"=="init" GOTO :init
GOTO :opt6
:init
docker exec %CONTAINER7% /bin/bash -c "/etc/init.d/mysql restart"
docker exec %CONTAINER7% /bin/bash -c "/etc/init.d/php-fpm restart"
docker exec %CONTAINER7% /bin/bash -c "/etc/init.d/httpd restart"
docker exec %CONTAINER8% /bin/bash -c "/etc/init.d/mysql restart"
docker exec %CONTAINER8% /bin/bash -c "/etc/init.d/php-fpm restart"
docker exec %CONTAINER8% /bin/bash -c "/etc/init.d/httpd restart"
GOTO:EOF

:opt6
IF "%1"=="shell" GOTO :shell
GOTO :done
:shell
IF "%2"=="" GOTO :usage
IF "%2"=="7" (docker exec -it %CONTAINER7% /bin/bash) ELSE (docker exec -it %CONTAINER8% /bin/bash)
GOTO:EOF

:done
echo "Done"
echo %USAGE%
echo "You entered %1 and %1"
GOTO:EOF
