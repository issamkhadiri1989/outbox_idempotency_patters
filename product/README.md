# PHP Application Stack

This project is built with Docker Compose and uses a PHP-FPM application container behind Nginx, with MySQL as the database and Traefik as the reverse proxy layer.

## Stack

- PHP: `php:8.4-fpm`
- Web server: Nginx
- Reverse proxy / TLS termination: Traefik
- Database: MySQL `8.4`
- Database administration: phpMyAdmin `5`
- Dependency manager: Composer
- Process manager: Supervisor
- Base OS packages: Debian-based image via official PHP Docker image

## Included services

### 1. PHP application container
The main application runs in `php` service using the official PHP FPM image.

It includes:

- Composer
- Xdebug
- APCu
- Redis
- MongoDB driver
- AMQP
- GD
- BCMath
- LDAP
- XSL
- Intl
- PDO MySQL
- OPCache
- ZIP
- Sockets

### 2. Nginx container
Nginx serves the application and forwards PHP requests to the PHP-FPM service.

### 3. MySQL container
The database is powered by:

- `mysql:8.4`

### 4. phpMyAdmin container
phpMyAdmin is included for database inspection and administration.

### 5. Traefik integration
The stack uses Traefik labels to expose the services through the external network `proxy-net` and configure HTTPS routing.

---

## Essential PHP extensions

The Dockerfile installs and enables the following extensions:

- `pdo_mysql` — MySQL database access
- `intl` — internationalization and locale support
- `opcache` — opcode caching for performance
- `zip` — ZIP archive handling
- `sockets` — socket communication support
- `amqp` — RabbitMQ messaging support
- `redis` — Redis caching/database client
- `mongodb` — MongoDB driver
- `apcu` — APCu cache
- `gd` — image manipulation library
- `bcmath` — arbitrary precision math
- `xsl` — XSL transformation support
- `ldap` — LDAP client support

### Additional system libraries and build dependencies

The image also installs packages required for PHP extension compilation and runtime support:

- `libicu-dev`
- `zlib1g-dev`
- `libxml2-dev`
- `libreadline-dev`
- `libzip-dev`
- `librabbitmq-dev`
- `libxslt-dev`
- `libldap2-dev`
- `libssl-dev`
- `build-essential`
- `autoconf`

---

## Development tools included

The PHP container includes several tools useful for local development:

- `bash-completion`
- `fish`
- `procps`
- `nano`
- `git`
- `unzip`
- `wget`
- `supervisor`
- `cron`
- `sudo`

---

## Notes

- Composer is installed from the official `composer:latest` image and copied into the PHP container.
- Xdebug is installed and enabled for debugging.
- The app working directory is `/var/www/html`.
- PHP configuration and custom INI files are mounted from `infra/php/config/php.ini` and `infra/php/xdebug/xdebug.ini`.

---

## Typical project flow

1. Run the stack with Docker Compose.
2. Serve the app through Nginx.
3. Connect the PHP app to MySQL.
4. Use phpMyAdmin for database inspection.
5. Debug with Xdebug and cache with OPCache/APCu/Redis.

This stack is well suited for a modern PHP application that needs database access, caching, queue support, image processing, LDAP integration, and development debugging tools.
