# Framework X CRUD

- Framework X. https://framework-x.org/
- Twig template engine: https://twig.symfony.com. All the templates are used from memory cache.
- Overriding HTTP method to support 'HEAD', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'PATCH', 'PURGE', 'TRACE' methods that are not support by HTML form. For more info -> https://github.com/symfony/http-foundation/blob/6.1/Request.php#L1194
- Sqlite package. https://github.com/clue/reactphp-sqlite
- PHP-watcher. https://github.com/seregazhuk/php-watcher

## Installation
    mkdir framework-x-database-crud
    cd framework-x-database-crud
    git clone git@github.com:mahmutbayri/framework-x-database-crud.git .
    composer install
    php migrate.php

## Live demo 

http://3.68.213.252:3000/tasks

> Depending on when your visit the address might not work.

## Running on local

    X_LISTEN=0.0.0.0:8081 php public/index.php

    // with watcher
    X_LISTEN=0.0.0.0:8081 ./vendor/bin/php-watcher --watch src --watch resources public/index.php --ext=php,twig

Navigate: http://localhost:8081/tasks

## Running on local with docker

### Test
    docker run \
    -e X_LISTEN=0.0.0.0:3000 \
    -it --rm --name my-running-script \
    -v "$PWD":/var/www/html \
    -p 8081:3000 \
    -w /var/www/html \
    php:8.2-cli \
    sh -c "docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl && php migrate.php && ./vendor/bin/php-watcher --watch src --watch resources public/index.php --ext=php,twig"
### Prod

    docker image rm -f framework-x-database-crud && docker build -t framework-x-database-crud --file DockerfileProd .
    docker container rm -f framework-x-database-crud-container && sleep 3 && docker run --name framework-x-database-crud-container -d -p 8081:3000 -e X_LISTEN=0.0.0.0:3000 framework-x-database-crud
    
    // Clean up
    docker container rm -f framework-x-database-crud-container
    docker image rm -f framework-x-database-crud

Navigate: http://localhost:8081/tasks

## Screenshots

List the tasks

![](screenshots/indexMedium.jpeg)

Create a task

![](screenshots/createMedium.jpeg)

Show a task

![](screenshots/showMedium.jpeg)

Edit a task

![](screenshots/editMedium.jpeg)
