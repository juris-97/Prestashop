#!/bin/bash

_DB_SERVER_=mariadb
_DB_NAME_=prestashop
_DB_USER_=root
_DB_PASSWD_=root
_DB_PREFIX_=ps_

sed -i "s|'localhost'|'${_DB_SERVER_}'|g" /var/www/html/config/settings.inc.php
sed -i "s|'prestashop'|'${_DB_NAME_}'|g" /var/www/html/config/settings.inc.php
sed -i "s|'P@ssw0rd'|'${_DB_PASSWD_}'|g" /var/www/html/config/settings.inc.php
sed -i "s|'ps_'|'${_DB_PREFIX_}'|g" /var/www/html/config/settings.inc.php