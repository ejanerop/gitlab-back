# Gitlab Manager API

App that uses the Gitlab API to display the projects and groups a user belongs to, and to remove members from them.

Frontend app: [Gitlab Manager](https://github.com/ejanerop/gitlab-front)

## Installation

Clone repository

```
git clone https://github.com/ejanerop/archivo_che.git
cd archivo_che
git checkout dev
```

Install dependencies

```
composer install
```

Setup environment file

```
cp .env.example .env
```

Generate application key

```
php artisan key:generate
```

Configure yor database connection in the .env file. By deafult, the database is configured to use the `mysql` driver and the database `gitlab`.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gitlab
DB_USERNAME=root
DB_PASSWORD=
```

Configure yor user data in the .env file. With this user and password you can login in the frontend app. If not configured, the next step will fail.

```
DEFAULT_USER=
DEFAULT_USER_PASSWORD=
DEFAULT_USER_GITLAB_TOKEN=
DEFAULT_USER_EMAIL=
```

Run migrations and seeder

```
php artisan migrate --seed
```

Run server

```
php artisan serve
```
