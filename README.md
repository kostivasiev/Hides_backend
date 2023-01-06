# Hides_backend

## Requirements

- all requirement for Laravel 7.0
- [composer](https://getcomposer.org/)
## Note

- Platform do not use L5's migrate system

## Install

### Step 1: install php library

*composer should be installed*

```
composer install
```

### Step 2: setup database
create `hideapp database and import hideapp.sql file`

`configuration` on .env file

```php
// file: .env
DBTEST_HOST=127.0.0.1
DBTEST_DATABASE=hideapp
DBTEST_USERNAME=root
DBTEST_PASSWORD=root123

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls

```

### Step 3: commands to runs 

```
    php artisan cache:clear
    php artisan config:clear
    php artisan storage:link
```
