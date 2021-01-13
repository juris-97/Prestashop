FROM alpine:3.5 as intermediate

RUN apk update
RUN apk add git vim nano

RUN git clone https://github.com/juris-97/Prestashop.git

FROM prestashop/prestashop:1.6.1.9


COPY --from=intermediate /Prestashop/prestashop .
RUN chmod -R 755 .
RUN chown -R www-data:www-data /var/www/html
RUN rm -rf install/


RUN mkdir ssl
COPY --from=intermediate /Prestashop/docker/ssl/000-default.conf /ssl/000-default.conf
COPY --from=intermediate /Prestashop/docker/mariadb/db_9.sql ./:/docker-entrypoint-initdb.d
COPY --from=intermediate /Prestashop/ssl.sh .
COPY --from=intermediate /Prestashop/init.sh .
COPY --from=intermediate /Prestashop/db.sh .


EXPOSE 80
EXPOSE 443
CMD [ "bash", "ssl.sh"]