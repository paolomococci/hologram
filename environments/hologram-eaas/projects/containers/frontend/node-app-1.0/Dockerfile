FROM node-pre-build-img:1.0

## self-signed-certificates
RUN mkdir -p /etc/ssl/self_signed_certs
COPY ./conf/self-signed-certificates /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/hologram*
RUN chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

## sites-available configurations
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

## I copy the sources into the dedicated directory
RUN mkdir -p /root/sources
COPY ./sources/ /root/sources

## I compile and install Node.js version 20.18.0
WORKDIR /root/sources
RUN tar -xzf node-v20.18.0.tar.gz
WORKDIR /root/sources/node-v20.18.0
RUN chmod 755 ./configure
RUN ./configure --verbose
RUN make && make install

## I'm doing a little cleaning
WORKDIR /root
RUN rm --recursive sources

## volume of web content
VOLUME ["/var/www/html"]

## I expose ports 22 and 443
## Port 80 is opened by default
EXPOSE 22 443 5173

## I copy and run the scripts with the commands
COPY ./scripts .
RUN chmod 700 ./setup.sh
RUN chmod 700 ./start.sh
CMD ["/bin/bash", "-c", "./start.sh"]