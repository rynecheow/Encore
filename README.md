#Encore! Online Ticketing System
![Encore icon](http://i.imgur.com/BDSz61V.png)

###Overview
A seamless, lightweight online ticketing system platform for ticket merchants and online customers.

**Written in PHP using the Symfony2 framework.**

To install a working copy, please make sure you have at least these running:

*	**Mac OS X 10.8 / Ubuntu 12.04**
*	**PHP 5.5+**
*	**Apache 2.2+**
*	**MySQL 5.6+**
*	**Any GUI database manager**

### Getting started
1.	Clone the repository in your local machine.
2.	Download **Composer** from [here](http://getcomposer.org/). Install it globally or locally.
3.	Run

```
composer install
```
to install all required dependency. This might take a while. Use all the default values when prompted (__except database username and password__ and ).
4. After Composer installed all its dependencies,
do:

```
php app/console assetic:dump
php app/console assets:install --symlink
```

to dump all the assets into the web root.
5.	Do

```
php app/console doctrine:database:create
```

to create the database for the system,
and

```
php app/console doctrine:schema:update --force
```

to update the schema and create the tables for the database.
6.	Edit your hosts files to add this two lines:

```
127.0.0.1	www.encore.com
0.0.0.0     merchant.encore.com
```
7.	You can start the server by running

```
php app/console server:run www.encore.com:{port}
```

for the customer server 
and 

```
php app/console server:run merchant.encore.com:{port}
```

for the merchant site.


