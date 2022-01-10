# Framework X CRUD

## Installation
    composer install
    php migrate.php

## Test

    X_LISTEN=0.0.0.0:8081 php public/index.php

    // with watcher
    X_LISTEN=0.0.0.0:8081 ./vendor/bin/php-watcher public/index.php

Navigate: http://localhost:8081/tasks
