FROM alpine:3.5 as intermediate

RUN apk update
RUN apk add git vim nano

RUN git clone https://github.com/juris-97/Prestashop.git

FROM prestashop/prestashop:1.6.1.9

ARG _DB_SERVER_=mariadb
ARG _DB_NAME_=prestashop
ARG _DB_USER_=root
ARG _DB_PASSWD_=root
ARG _DB_PREFIX_=ps_

COPY --from=intermediate /Prestashop/prestashop .
RUN chmod -R 755 .
RUN chown -R www-data:www-data /var/www/html
RUN rm -rf install/

RUN sed -i "s|'localhost'|'${_DB_SERVER_}'|g" ./config/settings.inc.php
RUN sed -i "s|'prestashop'|'${_DB_NAME_}'|g" ./config/settings.inc.php
RUN sed -i "s|'P@ssw0rd'|'${_DB_PASSWD_}'|g" ./config/settings.inc.php
RUN sed -i "s|'ps_'|'${_DB_PREFIX_}'|g" ./config/settings.inc.php

RUN mkdir ssl
COPY --from=intermediate /Prestashop/docker/ssl/000-default.conf /ssl/000-default.conf
COPY --from=intermediate /Prestashop/ssl.sh .

EXPOSE 80
EXPOSE 443
CMD [ "bash", "ssl.sh" ]