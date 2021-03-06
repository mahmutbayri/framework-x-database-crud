<?php

require_once __DIR__ . '/vendor/autoload.php';

use function React\Async\series;
use Clue\React\SQLite\Factory;

$factory = new Factory();
$db = $factory->openLazy(__DIR__ . '/sqlite.db');

series([
    function () use ($db) {
        return $db->exec('DROP TABLE IF EXISTS tasks;');
    },
    function () use ($db) {
        return $db->exec(
            "CREATE TABLE 'tasks' (
                    'id' INTEGER UNIQUE,
                    'title' TEXT,
                    'status' TEXT DEFAULT 'uncompleted' ,
                    PRIMARY KEY('id' AUTOINCREMENT)
                );
            CREATE INDEX status_index ON tasks (status);"
        );
    },
    function () use ($db) {
        return $db->exec("
        INSERT INTO tasks (title) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        INSERT INTO tasks (title) VALUES ('In vel metus non nulla imperdiet aliquam.');
        INSERT INTO tasks (title) VALUES ('Praesent mollis odio in eleifend hendrerit.');
        INSERT INTO tasks (title) VALUES ('Aenean tristique tortor eu metus congue commodo.');
        ");
    },
])->then(function ($results) use ($db) {
    echo 'Success: Migration completed (' . count($results) .').'. PHP_EOL;
    $db->quit();
}, function (Exception $e) use ($db) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    $db->quit();
});
