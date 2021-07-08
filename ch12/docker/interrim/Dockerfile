FROM unlikelysource/lfphp_with_php_8_1:latest
MAINTAINER doug@unlikelysource.com
COPY php8_tips.sql /tmp/php8_tips.sql
COPY startup.sh /tmp/startup.sh
COPY php.ini /etc/php.ini
RUN \
    echo "Setting up Apache ..." && \
    echo "ServerName php8_tips_php8_1" >> /etc/httpd/httpd.conf && \
    chmod +x /tmp/*.sh
RUN \
    echo "Configuring php.ini file permissions ..." && \
    chown apache:apache /etc/php.ini &&  \
    chmod 664 /etc/php.ini
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 7 && \
    mysql -uroot -v -e "CREATE DATABASE php8_tips;" && \
    mysql -uroot -v -e "CREATE USER 'php8'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'php8'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
    mysql -uroot -e "SOURCE /tmp/php8_tips.sql;" php8_tips
RUN \
    echo "Installing phpMyAdmin ..." && \
    wget -O /tmp/phpmyadmin_install.sh https://opensource.unlikelysource.com/phpmyadmin_install.sh && \
    chmod +x /tmp/*.sh && \
    /tmp/phpmyadmin_install.sh 5.1.1
RUN \
    echo "Installing PHP zip extension ..." && \
    pecl channel-update pecl.php.net && \
    pecl install zip
RUN \
    echo "Installing the Swoole extension ..." && \
    cd /tmp && \
    git clone https://github.com/swoole/swoole-src.git && \
    cd swoole-src && \
    phpize && \
    ./configure --enable-sockets --enable-swoole-json --enable-swoole-curl && \
    make && \
    make install && \
    rm -rf /tmp/swoole-src && \
    echo "extension=swoole.so" >>/etc/php.ini
RUN \
    echo "Setting up other links ..." && \
    ln -s /bin/lfphp-get /usr/bin/apt && \
    ln -s /bin/lfphp-get /usr/bin/apt-get
RUN \
    echo "Installing Composer 2.x ..." && \
    cd /tmp && \
    wget https://getcomposer.org/download/latest-2.x/composer.phar && \
    cp composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer
CMD /tmp/startup.sh
