# lumen-sail
Installing Laravel Sail Package in Lumen


## Warning!!! 
### maximum supported version of laravel/sail v1.19.0, I plan to add support for newer versions in the near future.

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