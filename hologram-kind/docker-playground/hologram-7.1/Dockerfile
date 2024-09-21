## I use a previously created local image
FROM hologram-img:7.0

## user
USER root

## self-signed-certificates
RUN mkdir -p /etc/ssl/self_signed_certs
COPY ./conf/self-signed-certificates /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/hologram*
RUN chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

## mods-available and sites-available configurations
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

## restart the web server
RUN service apache2 restart

## default web content
VOLUME ["/var/www/html"]

## I expose port 443 TCP
EXPOSE 443

## from root directory
WORKDIR /root

## command written in exec form
COPY ./scripts/start.sh ./start.sh
RUN chmod 700 ./start.sh
CMD ["/bin/bash", "-c", "./start.sh"]