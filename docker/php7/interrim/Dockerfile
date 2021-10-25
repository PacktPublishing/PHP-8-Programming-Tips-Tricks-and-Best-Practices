FROM asclinux/linuxforphp-8.2-ultimate:7.1-nts
MAINTAINER doug@unlikelysource.com
COPY php8_tips.sql /tmp/php8_tips.sql
COPY startup.sh /tmp/startup.sh
COPY pgsql_users_create.sql /tmp/pgsql_users_create.sql
COPY postgresql_setup.sh /tmp/postgresql_setup.sh
RUN chmod +x /tmp/*.sh
RUN \
    echo "Enable display errors + configure php.ini for opcache ..." && \
    cp /etc/php.ini /tmp/php.ini && \
    sed -i 's/display_errors = Off/display_errors = On/g' /etc/php.ini && \
    sed -i 's/display_startup_errors = Off/display_startup_errors = On/g' /etc/php.ini && \
    sed -i 's/error_reporting =/;error_reporting =/g' /etc/php.ini && \
    echo "error_reporting = E_ALL" >>/etc/php.ini && \
    chown apache:apache /etc/php.ini &&  \
    chmod 664 /etc/php.ini
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 7 && \
    mysql -uroot -v -e "CREATE DATABASE php8_tips;" && \
    mysql -uroot -v -e "CREATE USER 'php8'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'php8'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;"
RUN \
    echo "Installing phpMyAdmin ..." && \
    wget -O /tmp/phpmyadmin_install.sh https://opensource.unlikelysource.com/phpmyadmin_install.sh && \
    chmod +x /tmp/*.sh && \
    /tmp/phpmyadmin_install.sh 5.0.4
RUN \
    echo "Installing Zip Extension ..." && \
    lfphp-get php-ext zip-1.19.2
RUN \
    echo "Enabling OpCache ..." && \
    sed -i 's/;zend_extension=opcache/zend_extension=opcache/g' /etc/php.ini && \
    sed -i 's/;opcache.enable=1/opcache.enable=1/g' /etc/php.ini && \
    sed -i 's/;opcache.enable_cli=0/opcache.enable_cli=1/g' /etc/php.ini && \
    sed -i 's/;opcache.memory_consumption=128/opcache.memory_consumption=256/g' /etc/php.ini
RUN \
    echo "Setting up other links ..." && \
    ln -s /bin/lfphp-get /usr/bin/apt && \
    ln -s /bin/lfphp-get /usr/bin/apt-get
RUN \
    echo "Installing Composer 1.x ..." && \
    cd /tmp && \
    wget https://getcomposer.org/download/latest-1.x/composer.phar && \
    cp composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer
RUN \
    echo "Setting up Apache ..." && \
    echo "ServerName php8_tips_php7" >> /etc/httpd/httpd.conf && \
    chmod +x /tmp/*.sh
RUN \
    echo "Don't forget to set up the PostgreSQL database ... " && \
    echo "run: /tmp/postgresql_setup.sh"
CMD /tmp/startup.sh
