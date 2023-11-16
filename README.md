# lumen-sail
Installing Laravel Sail Package in Lumen

`composer require histel/lumen-sail`

Add this line to bootstrap/app.php

```PHP
$app->register(\Histel\LumenSail\LumenSailServiceProvider::class);
```