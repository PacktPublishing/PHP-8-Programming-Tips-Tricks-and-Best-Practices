FROM asclinux/linuxforphp-8.2-ultimate:7.1-nts
MAINTAINER doug.bierer@etista.com
RUN \
    echo "Restoring code from book repository ..." && \
    git clone https://github.com/PacktPublishing/PHP-8-Programming-Tips-Tricks-and-Best-Practices.git /repo && \
    cd /repo && \
    cp sample_data/*.db /tmp && \
    rm -rf /repo/.git
RUN \
    echo "Enable display errors and configure php.ini for modifications later ..." && \
    sed -i 's/display_errors = Off/display_errors = On/g' /etc/php.ini && \
    sed -i 's/display_startup_errors = Off/display_startup_errors = On/g' /etc/php.ini && \
    sed -i 's/error_reporting =/;error_reporting =/g' /etc/php.ini && \
    echo "error_reporting = E_ALL" >>/etc/php.ini && \
    cp /etc/php.ini /tmp/php.ini && \
    chown apache:apache /etc/php.ini &&  \
    chmod 664 /etc/php.ini
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 5 && \
    mysql -uroot -v -e "CREATE DATABASE php8_tips;" && \
    mysql -uroot -v -e "CREATE USER 'php8'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'php8'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
    mysql -uroot -e "SOURCE /repo/sample_data/php8_tips.sql;" php8_tips
RUN \
    echo "Installing phpMyAdmin ..." && \
    lfphp-get phpmyadmin
RUN \
    echo "Setting up Apache ..." && \
    echo "ServerName php8_tips_php7" >> /etc/httpd/httpd.conf && \
    mv -f /srv/www /srv/www.OLD && \
    ln -sfv /repo /srv/www && \
    chown apache:apache /srv/www && \
    chown -R apache:apache /repo && \
    chmod -R 775 /repo
CMD lfphp --mysql --phpfpm --apache

