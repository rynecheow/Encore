#!/bin/bash
sudo apt-get install python-software-properties

sudo add-apt-repository ppa:ondrej/php5

sudo add-apt-repository ppa:ondrej/php5-oldstable

sudo apt-add-repository ppa:chris-lea/node.js

sudo apt-get update

sudo apt-get dist-upgrade

sudo apt-get install php5-mysql nodejs npm mysql-server-5.5 mysql-client-core-5.5 php5 php5-cli curl git php5-curl php5-intl

curl -sS https://getcomposer.org/installer | php

sudo mv composer.phar /usr/local/bin/composer

sudo npm install -g uglify-js

sudo npm install -g uglifycss

cd ~/Documents

git clone https://github.com/rynecheow/Encore.git

cd Encore

composer install


