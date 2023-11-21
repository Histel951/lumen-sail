composer require laravel/sail:1.19.0 &&
php artisan sail:install &&
vendor/bin/sail build --no-cache &&
vendor/bin/sail up -d