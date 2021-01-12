#!/bin/bash

#docker exec -i prestashop_mariadb_1 mysql --user root --password=root prestashop < ./dump.sql

DATABASE_NAME="db_9"
DATABASE_USER="user_9"
DATABASE_PASSWORD="password"


docker exec -i prestashop_mariadb_1 mysql --user root --password=root -e "CREATE DATABASE IF NOT EXISTS db_9;"
docker exec -i prestashop_mariadb_1 mysql --user root --password=root -e "CREATE USER IF NOT EXISTS user_9@'%' IDENTIFIED BY 'password';"
docker exec -i prestashop_mariadb_1 mysql --user root --password=root -e "GRANT ALL PRIVILEGES ON db_9.* TO 'user_9'@'%';"
docker exec -i prestashop_mariadb_1 mysql --user root --password=root -e "FLUSH PRIVILEGES;"

docker exec -i prestashop_mariadb_1 mysql --user user_9 --password=password db_9 < ./docker/mariadb/db_9.sql