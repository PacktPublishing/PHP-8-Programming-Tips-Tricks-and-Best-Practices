FROM unlikelysource/php8_tips_7_1_interrim:latest
MAINTAINER doug@unlikelysource.com
COPY php8_tips.sql /tmp/php8_tips.sql
COPY startup.sh /tmp/startup.sh
RUN \
    echo "Restoring sample database ..." && \
    /etc/init.d/mysql start && \
    sleep 7 && \
    mysql -uroot -e "SOURCE /tmp/php8_tips.sql;" php8_tips
RUN \
    echo "Updating Composer 2.x ..." && \
    /usr/bin/composer self-update
bash-4.3$ exitCMD /tmp/startup.sh
