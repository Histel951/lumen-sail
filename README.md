# lumen-sail
Installing Laravel Sail Package in Lumen

```shell
$ composer require laravel/sail:1.19.0
```

```shell
$ composer require histel/lumen-sail
```

Add this line to bootstrap/app.php

```PHP
$app->register(\Histel\LumenSail\LumenSailServiceProvider::class);
```

Installing scaffolding

```shell
$ php artisan sail:install
```

Build && Start docker containers

```shell
$ vendor/bin/sail build --no-cache
```

```shell
$ vendor/bin/sail up -d
```

Sail documentation - https://laravel.com/docs/10.x/sail