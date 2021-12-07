# xgeeks tech assignment

## Requirements

- [Docker](https://www.docker.com/products/docker-desktop)
- [Postman](https://www.postman.com/downloads/)

## Info

- [Laravel 8 Info](https://laravel.com/docs/8.x/installation)
- [Structure](structure.md)

## Installation/Configuration

### Install dependencies

#### macOS / Linux

```
docker run --rm -v $(pwd):/app composer install
```

#### Windows (Git Bash)

```
docker run --rm -v /$(pwd):/app composer install
```

#### Windows (Powershell)

```
docker run --rm -v ${PWD}:/app composer install
```

### Copy all file .env.example to .env

In terminal if you use macOS / Linux / Git Bash(Windows)

```
cp .env.example .env
```

Change database configurations in **.env**

```
DB_CONNECTION=mysql
DB_HOST=mysql_xgeeks
DB_PORT=3306
DB_DATABASE=xgeeks-assignment
DB_USERNAME=root
DB_PASSWORD=yourdatabasepassword
```

### Configure PHPUnit file

change value line **25** phpunit.xml in **phpunit.xml**

```
<server name="DB_DATABASE" value="yourdatabasename"/>
```

### Detach the application

```
docker-compose up -d
```

### Generate APP Key

```
docker-compose exec app php artisan key:generate
```

### Run the migrations and seed script

```
docker-compose exec app php artisan migrate --seed
```

### Local database connection

```
HOST:127.0.01
PORT:3300
USER:root
PASSWORD:yourdatabasepassword
DATABASE:xgeeks-assignment
```

### URL http://localhost:8800

## Login

- Go your database and seed the fake users created and choose one
- Password for users -> **password**

### Endpoints

#### Create a Token

> Headers must include Accept:application/json

- **POST** - http://localhost:8800/api/login
