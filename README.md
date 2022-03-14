# Product Review

a service for reviewing products and rankings

## Table of Contents

- [Prerequisites](#prerequesties)
- [Install](#install)

## Prerequisites

- docker
- docker-compose

## Install

1. clone project.
2. copy the `.env.example` to `.env`
3. `docker-compose up -d`
4. `docker-compose exec -it product_review_php bash`
5. `$ composer install`
6. set environment variables like below :

```
NGINX_EXPOSED_PORT=8080
MYSQL_EXPOSED_PORT=33060
REDIS_EXPOSED_PORT=6379
...
DB_DATABASE=app
DB_PASSWORD=password
...
DB_HOST=mysql
REDIS_HOST=redis
```

7. `$ php artisan key:generate`
8. `$ sudo chmod -R 777 storage && sudo chown -R USER:www-data storage`
9. `$ php artisan migrate --seed`
