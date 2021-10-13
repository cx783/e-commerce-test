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

Go to http://localhost:8000 in the browser

For admin facing go direct to: http://localhost:8000/login