FROM unlikelysource/php8_tips_8_0_interrim:latest
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
RUN \
    echo "Enabling FFI for all operations ..." && \
    echo "ffi.enable=on" >> /etc/php.ini
CMD /tmp/startup.sh
