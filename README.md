# lumen-sail
Installing Laravel Sail Package in Lumen

## Script install: 

```shell
$ composer require histel/lumen-sail
```

Add this line to bootstrap/app.php

```PHP
$app->register(\Histel\LumenSail\LumenSailServiceProvider::class);
```

```shell
$ vendor/bin/lumen-sail 
```

## Manual installation:

```shell
$ composer require histel/lumen-sail
```

```shell
$ composer require laravel/sail
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
