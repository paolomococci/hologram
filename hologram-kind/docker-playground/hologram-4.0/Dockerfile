FROM debian:12.7

## I update and upgrade
RUN apt-get update && apt-get upgrade -y

## I install some network tools
RUN apt-get install -y iproute2 iputils-ping

## I install web server Apache 2
RUN apt-get install -y apache2 apache2-utils libapache2-mod-fcgid

## I install a development environment for the PHP language 
RUN apt-get install -y build-essential autoconf libtool bison re2c pkg-config libssl-dev libcurl4-openssl-dev libbz2-dev libjpeg-dev libgmp3-dev libxslt1-dev libpng-dev libsqlite3-dev libonig-dev apache2-dev libxml2-dev libffi-dev

## I install a handy editor and a monitor of resources
RUN apt-get install -y nano btop

## I automatically remove all unused packages
RUN apt autoremove -y

## self-signed-certificates
RUN mkdir -p /etc/ssl/self_signed_certs
COPY ./conf/self-signed-certificates /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/hologram*
RUN chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

## mods-available and sites-available configurations
COPY ./conf/mods-available/dir.conf /etc/apache2/mods-available/dir.conf
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN sed -i '$aServerName 127.0.0.1' /etc/apache2/apache2.conf
RUN sed -i '$aSSLPassPhraseDialog exec:/etc/ssl/self_signed_certs/echo_passphrase.sh' /etc/apache2/apache2.conf

## activate all necessary modules and restart the web server
RUN a2enmod ssl && a2enmod rewrite && a2enmod headers && a2ensite default-ssl

## default web content
COPY ./dev/landing/dist/ /var/www/html

## I expose port 443 TCP
EXPOSE 443

## command written in shell form
# CMD apache2ctl -D FOREGROUND

## command written in exec form
CMD ["apache2ctl", "-D", "FOREGROUND"]