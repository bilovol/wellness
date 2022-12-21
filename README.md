# User integrations

###### Marketing project

[![Framework](https://img.shields.io/badge/Lumen-%5E7.0-orange)](https://lumen.laravel.com/docs/9.x)
[![php](https://img.shields.io/badge/php-%5E7.2.5-blue)](https://www.php.net/ChangeLog-7.php#PHP_7_2)
[![docker-compose](https://img.shields.io/badge/docker--compose-3.7-yellow)](https://docs.docker.com/compose/compose-file/compose-versioning/)

## Deploy

* `cp .env.prod .env`
* set `***` into `.env`
* `make build`
* `make up`
* `make exec`
* `composer install`
* `php artisan migrate`
* `exit`
* `make queue-start`

## Command list

| command              | description             |
|:---------------------|-------------------------|
| `make build`         | build docker containers |
| `make up`            | start docker containers |
| `make down`          | stop docker containers  |
| `make exec`          | exec -it php-fpm        |
| `make queue-start`   | run queue               |
| `make queue-list`    | list queue              |
| `make queue-log`     | realtime queue log      |
| `make queue-monitor` | monitor queue           |
| `make queue-stop`    | stop consumers          |
| `make queue-restart` | restart queue           |

[![telegram](https://img.shields.io/badge/contact-@bilovol-blue)](https://t.me/genia_b)
