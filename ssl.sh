find themes/etrendlite/mails -type f -exec sed -i "s/localhost/localhost/" {} \;
cd ssl
touch apache-selfsigned.key
touch apache-selfsigned.crt
cd ..
rm -rf /etc/apache2/sites-available/000-default.conf
cp /ssl/000-default.conf /etc/apache2/sites-available/000-default.conf
openssl req -newkey rsa:2048 -new -nodes -x509 -days 365 -keyout /ssl/apache-selfsigned.key -out /ssl/apache-selfsigned.crt -subj "/C=PL/ST=Pomerania/L=Gdansk/O=PG/OU=./CN=."
cp /ssl/apache-selfsigned.key /etc/ssl/private/apache-selfsigned.key
cp /ssl/apache-selfsigned.crt /etc/ssl/certs/apache-selfsigned.crt
a2enmod ssl
a2enmod rewrite
apachectl -D FOREGROUND
