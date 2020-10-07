#
# PHP 8 Tips, Tricks, Techniques
#

# Pull base image.
FROM asclinux/linuxforphp-8.2-ultimate:8.0dev-nts
COPY ./hosts /etc/hosts
COPY ./init.sh /tmp/init.sh
RUN chmod +x /tmp/*.sh
RUN /tmp/init.sh
CMD lfphp --mysql --apache --phpfpm
