<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## About LaraStarter
LaraStarter built to cut initial creation time of a laravel project. LaraStarter attempts to take the pain out of creating laravel project by adding a few of existing library, such as:

- [AdminLTE](https://adminlte.io).
- [Spatie Laravel Permission](https://github.com/spatie/laravel-permission).
- [Yajra Datatables](https://github.com/yajra/laravel-datatables).

## Setup
Place this project to anywhere in your environment, and then do following steps inside your project directory:

install dependencies
```
$ composer update
```

update .env file
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

generate laravel's app key
```
php artisan key:generate
```

execute laravel's migration and seeds
```
php artisan migrate --seed
```

run laravel application
```
php artisan serve
```
