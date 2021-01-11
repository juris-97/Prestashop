#!/bin/bash

sed -i "s|'localhost'|'mariadb'|g" ./prestashop/config/settings.inc.php
sed -i "s|'P@ssw0rd'|'root'|g" ./prestashop/config/settings.inc.php


