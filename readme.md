## Synopsis

Simple "Gacha Only" Browser Game for 1 presentation

([What is gacha ?](https://bothgunsblazingblog.wordpress.com/2013/08/07/gacha/))

## Include
PHP Laravel 

## Installation & Test

### Create database
```
cd htdocs/
composer create-project laravel/laravel SimpleGacha
cd SimpleGacha
touch storage/gacha.sqlite
```
### Migrate and Seed
```
php artisan migrate
composer dump-autoload
php artisan db:seed
```
## Contributors

Nguyen Hoang Khanh (khanh.nguyen@dena.jp)