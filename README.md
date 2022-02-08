# Calendar API

## Requirements

- [Docker](https://www.docker.com/products/docker-desktop)
- [Postman](https://www.postman.com/downloads/)

## Info

- [Laravel 9 Info](https://laravel.com/docs/9.x/installation)
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
DB_HOST=mysql_calendar
DB_PORT=3306
DB_DATABASE=calendar-api
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
DATABASE:calendar-api
```

### URL http://localhost:8800

## Login

- Go your database and seed the fake users created and choose one
- Password for users -> **password**

### Endpoints

> Headers must include Accept:application/json

#### Create a Token

- **POST** - http://localhost:8800/api/login

#### Availabilities

##### Data example

````
{
    "start_date":"2021-12-24",
    "end_date": "2021-12-24",
    "day":"Friday"
    "start_time":"21:30",
    "end_time": "22:00"
}
````

- **GET** - http://localhost:8800/api/availabilities -> Get combined availabilities
- **POST** - http://localhost:8800/api/availabilities -> Create new availability
- **PUT** - http://localhost:8800/api/availabilities/{id} ->  Edit a Availability
- **DELETE** - http://localhost:8800/api/availabilities/{id} ->  Delete a Availability

#### Events

##### Data example

````
{
    "name":"Event x"
    "day_date":"2021-12-24",
    "start_ime": "08:00",
    "end_time":"09:00",
    "description":"notes about this meeting"
    "users":[1,2,3,4,5]
}
````

- **POST** - http://localhost:8800/api/events -> Create new Event
- **PUT** - http://localhost:8800/api/events/{id} ->  Edit a Event
- **DELETE** - http://localhost:8800/api/events/{id} -> Delete a Event




