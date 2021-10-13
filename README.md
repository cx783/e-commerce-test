## Instalation

### Clone this repository

```sh
git clone https://github.com/cx783/e-commerce-test
```

### Run the next command
*Ensure you have installed php 7.4, nodejs, npm, composer & mysql*

Install backend dependencies
```sh
composer install
```

Copy the .env.example as .env
```sh
cp .env.example .env
```

Create an empty database in Mysql (or MariaDB) and set the proper conexion configuration in the .env file

Run migrations and seeder
```sh
php artisan migrate
php artisan db:seed
```

Create symbolic link for images
```sh
php artisan storage:link
```

Install frontend dependecies
```
npm install
```

Compile assets
```
npm run prod
```

Up the local server
```sh
php artisan serve
```

Consider than laravel sanctum is being used, so you will have to configure the port in the .env file, in case of not using laravel's default port
```sh
SANCTUM_STATEFUL_DOMAINS=localhost:{MY_CUSTOM_PORT}
```

This applies also to the APP_URL variable
```sh
APP_URL=http://localhost:{MY_CUSTOM_PORT}
```

Go to http://localhost:8000 in the browser

For admin facing go direct to: http://localhost:8000/login