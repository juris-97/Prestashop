#!/bin/bash

docker exec -i prestashop_mariadb_1 mysql --user root --password=root prestashop < ./dump.sql