# Shopway Backend Application

## Description
A multi vendor shop. Technology stack used: Docker, Laravel 6, MySQL 5.7, React

# Docker for Linux and Window OS
## Up and running
Clone the  Repo:
```
$ git clone -b master https://github.com/businessin/shopway-api-pl
$ cd shopway-api-pl
```

Build the images and start the services:
```
$ cd .docker
./start.sh dev
```

## Hosts Configuration

Hosts:
OSX & Linux:
```
sudo nano /etc/hosts
```
```
127.0.0.1   shopway.polcode.site
```

## App configuration
1) Let's check the web app image name:
```
docker ps
```
2) Let's connect with it:
```
docker exec -it Shopway-web /bin/bash
```

3) Running the migrations:
Migrations are launched by the Docker scripts at startup

4) Copying the environment file inside docker:
```
cd /var/www/html/
cp .env.example .env
```

5) Running seeders

<b>This will load ALL of the seeders (please aware of the possibles duplicates! use only with empty DB):</b>
```
cd /var/www/html/
php artisan db:seed
```

<b>To load a single, new seeder please use:</b>
```
cd /var/www/html/
php artisan db:seed --class=NewSingleSeeder
```

<b>System checks the type of the environment, for "local" environments a AddTestDataDevEnvOnly seeder is added. It contains many test records. If you wish to run this manually on some other environments please do as follows:</b>
```
cd /var/www/html/
php artisan db:seed --class=AddTestDataDevEnvOnly
```
6) Generating keys and cache clearing:
Both of them are launched by the Docker scripts at startup

7) Composer dependencies:
Launched by the Docker scripts at startup

8) Default first Super User:
```
username: SuperAdmin
password: password
email: admin@admin.local

SuperAdmin is a softwareowner for the client #ID = 1, Shopway
```


## Running
Type:
```
http://shopway.polcode.site/
```
into web browser, basic authorization should prompt for login and password:

```
login: polcode
password: polcode
```


# Alternative - LaraDock for OSX
For some reason the Docker from above is not working on the OSX. To run the code please follow the instruction bellow.
## Up and running
1. To install this on Mac OSX please use the instruction from:
https://github.com/businessin/shopway-frontend-homepage
