#!/bin/bash

_DB_USER_=user_9
_DB_PASSWD_=password

sed -i '0,/root/{s/root/'${_DB_USER_}'/}'  ./settings.inc.php
sed -i 's/root/'${_DB_PASSWD_}'/g'         ./settings.inc.php