FROM unlikelysource/php8_tips_8_1_interrim:latest
MAINTAINER doug@unlikelysource.com
COPY php8_tips.sql /tmp/php8_tips.sql
COPY startup.sh /tmp/startup.sh
COPY php-fpm.conf /etc/php-fpm.conf
RUN \
    echo "Restoring sample database ..." && \
    /etc/init.d/mysql start && \
    sleep 7 && \
    mysql -uroot -e "SOURCE /tmp/php8_tips.sql;" php8_tips
RUN \
    echo "Updating php.ini file ..." && \
    sed -i 's/extension=zip/;extension=zip/g' /etc/php.ini && \
    sed -i 's/error_reporting = E_ALL/error_reporting = E_ALL ^ E_DEPRECATED/g' /etc/php.ini
RUN \
    echo "Updating Composer 2.x ..." && \
    /usr/bin/composer self-update
CMD /tmp/startup.sh
