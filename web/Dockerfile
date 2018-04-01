FROM ubuntu:latest

ENV DEBIAN_FRONTEND noninteractive
ENV INITRD No
ENV RUNLEVEL 1
RUN apt-get update && apt install -y supervisor apache2 php libapache2-mod-php\
    php-curl php-gd php-cli php-mysql php-xml php-mbstring\
    locales php7.0-fpm

RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8

RUN a2enmod proxy_fcgi setenvif
RUN a2enconf php7.0-fpm
RUN a2dismod php7.0
RUN a2dismod mpm_prefork
RUN a2enmod mpm_event

RUN service php7.0-fpm start

RUN rm /var/www/html/index.html
ADD html/ /var/www/html/

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]
