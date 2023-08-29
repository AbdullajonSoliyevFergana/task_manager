## Installation
- Firstly, clone the project:

```shell
git clone https://github.com/AbdullajonSoliyevFergana/task_manager.git
```


- In your terminal/cmd change your directory to project directory:

```shell
cd task_manager
```


- While you are in root directory of the project you have to install all required packages:

```shell
composer install
```


- Copy _.env.example_ as _.env_:

```shell
cp .env.example .env
```


- In your _.env_ write your Database credentials:
  **Example:**

```shell
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=my_db
DB_USERNAME=postgres
DB_PASSWORD=password
```


- Generate key:

```shell
php artisan key:generate
```

- Clear cache:

```shell
php artisan optimize
```

- Connect db postgresql and run migrations:

```shell
php artisan migrate
```

- Run the project:

```shell
php artisan serve
```

- Show APIs with Swagger:

```shell
http://127.0.0.1:8000/api/documentation
```
