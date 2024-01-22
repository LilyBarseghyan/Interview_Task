How to run demo application
===========================

If you have PostgreSQL installed, please create database with name 'laravel'. Or if you prefer Docker, please run following command to bring up database:

```docker run -e POSTGRES_PASSWORD=123 -e POSTGRES_DB=laravel -p 5432:5432 -d postgres```

Next please create '.env' having '.env.example' as template. Make sure you have correct configuration of database related variables.

To start application please run following commands:
```
composer install

npm install
npm run build

php artisan key:generate
php artisan migrate
php artisan serve
```

If all commands executed successfully you will be able to open http://127.0.0.1:8000 in you favorite browser and enjoy.
