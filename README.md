# Framework X CRUD

- Framework X. https://framework-x.org/
- Twig template engine: https://twig.symfony.com. All the templates are used from memory cache.
- Overriding HTTP method to support 'HEAD', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'PATCH', 'PURGE', 'TRACE' methods that are not support by HTML form. For more info -> https://github.com/symfony/http-foundation/blob/6.1/Request.php#L1194
- Sqlite package. https://github.com/clue/reactphp-sqlite
- PHP-watcher. https://github.com/seregazhuk/php-watcher

## Installation
    composer install
    php migrate.php

## Test

    X_LISTEN=0.0.0.0:8081 php public/index.php

    // with watcher
    X_LISTEN=0.0.0.0:8081 ./vendor/bin/php-watcher --watch src --watch resources public/index.php --ext=php,twig

Navigate: http://localhost:8081/tasks
