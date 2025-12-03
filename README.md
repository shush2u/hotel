## Initial setup

Clone project locally, aquire or setup your own .env file.

Install NVM:
```
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
```

Run install script for NVM and setup node:
```
source ~/.nvm/nvm.sh
nvm install 22
nvm use 22
```

Install PHP and Composer
```
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
```

Go to local project root dir and install dependencies.

e.g. if in ~/hotel
```
cd ~/hotel
composer install
npm install
```

MySQL db runs on default ports, change them in docker-compose.yml to a available port if needed.
e.g. of changing MYSQL port
```
services:
  mysql:
    image: mysql:latest
    container_name: hotel-mysql-db
    restart: always
    ports:
      - "XXXX:3306" <- change left number
    environment:
    ...
```

Run DB and PhpMyAdmin:
```
docker compose up -d mysql phpmyadmin
```

Run migration atleast once before using to setup database:
```
php artisan migrate:fresh
```

(Optionally) seed database with examples, will generate users, rooms, reviews, etc. By default after migration db is empty so you'll need to setup a admin user yourself otherwise.
```
php artisan db:seed
```

Website should now be ready to run.

Running: <br>

(DB has to be running for project to work properly).

Run page dev server
```
composer run dev
```

Should be accessible at localhost:8000 (or your defined port in .env).

To run completely dockerized:
```
docker compose up -d
```
Page should be accessible at localhost:8080