FROM lamp-app-img:1.0

## set a default self-signed-certificates
COPY ./conf/self-signed-certificates /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/hologram*
RUN chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

## set a default sites-available configurations
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

## volume of web content
VOLUME ["/var/www/html"]

## I expose ports 22, 443 and 9003
EXPOSE 22 80 443 9003

## I copy and run the script with the commands
COPY ./scripts .
RUN chmod 700 ./setup.sh
RUN chmod 700 ./start.sh
CMD ["/bin/bash", "-c", "./start.sh"]