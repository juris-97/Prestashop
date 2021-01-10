FROM alpine:3.5 as intermediate

RUN apk update
RUN apk add git

#RUN git clone --single-branch https://github.com/ PATH TO OUR GITHUB

FROM prestashop/prestashop:1.6.1.9

ARG DATABASE_HOST=mariadb
ARG DATABASE_PORT=''
ARG DATABASE_NAME=prestashop
ARG DATABASE_PASSWORD=root
ARG DATABASE_PREFIX=ps_

COPY --from=intermediate /prestashop .
RUN chmod -R 755 .
RUN chown -R www-data:www-data /var/www/html
RUN rm -rf install/

RUN sed -i "s|'mariadb'|'${DATABASE_HOST}'|g" ./app/config/parameters.php
RUN sed -i "s|''|'${DATABASE_PORT}'|g" ./app/config/parameters.php
RUN sed -i "s|'prestashop'|'${DATABASE_NAME}'|g" ./app/config/parameters.php
RUN sed -i "s|'database_user' => 'root'|'database_user' => '${DATABASE_USER}'|g" ./app/config/parameters.php
RUN sed -i "s|'database_password' => 'root'|'database_password' => '${DATABASE_PASSWORD}'|g" ./app/config/parameters.php
RUN sed -i "s|'ps_'|'${DATABASE_PREFIX}'|g" ./app/config/parameters.ph

RUN mkdir ssl
COPY --from=intermediate /docker/ssl/000-default.conf /ssl/000-default.conf
COPY --from=intermediate /ssl.sh .

EXPOSE 80
EXPOSE 443
CMD [ "bash", "ssl.sh" ]