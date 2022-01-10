<?php

require __DIR__ . '/../bootstrap.php';

$app = new FrameworkX\App();

$factory = new \Clue\React\SQLite\Factory();
$db = $factory->openLazy(SQLITE_DB_PATH);

// list
$app->get('/tasks', function () use ($db) {
    return $db->query(
        'SELECT * FROM tasks'
    )->then(function (Clue\React\SQLite\Result $result) {
        return new React\Http\Message\Response(
            200,
            [],
            array_reduce($result->rows, function ($carry, $item){
                return $carry . $item['title'] . '<br/>';
            }, '')
        );
    });
});

// new
$app->post('/tasks', function (Psr\Http\Message\ServerRequestInterface $request) use ($db) {
    $fields = $request->getParsedBody();
    return $db->query('INSERT INTO tasks (title) VALUES (?)', [$fields['title']])->then(
        function (Clue\React\SQLite\Result $result) {
            return new React\Http\Message\Response(
                301,
                ['Location: /tasks'],
                'inserted'
            );
        },
        function (Exception $e) {
            return new React\Http\Message\Response(
                200,
                [],
                'Error: ' . $e->getMessage() . PHP_EOL
            );
        }
    );
});

//show
$app->get('/tasks/{id}', function (Psr\Http\Message\ServerRequestInterface $request) use ($db) {
    $id = $request->getAttribute('id');
    return $db->query(
        'SELECT * FROM tasks WHERE id = ?',
        [$id]
    )->then(function (Clue\React\SQLite\Result $result) {
        return new React\Http\Message\Response(
            200,
            [],
            json_encode($result->rows)
        );
    });
});

//update
$app->put('/tasks/{id}', function (Psr\Http\Message\ServerRequestInterface $request) use ($db) {
    $id = $request->getAttribute('id');
    $fields = $request->getParsedBody();
    return $db->query(
        'UPDATE tasks SET title = ? WHERE id = ?',
        [$fields['title'], $id]
    )->then(function (Clue\React\SQLite\Result $result) {
        return new React\Http\Message\Response(
            200,
            [],
            $result->changed ? 'updated' : 'not found'
        );
    });
});

// destroy
$app->delete('/tasks/{id}', function (Psr\Http\Message\ServerRequestInterface $request) use ($db) {
    $id = $request->getAttribute('id');
    return $db->query(
        'DELETE FROM tasks WHERE id = ?',
        [$id]
    )->then(function (Clue\React\SQLite\Result $result) {
        return new React\Http\Message\Response(
            301,
            ['Location: /tasks'],
            $result->changed ? 'deleted' : 'not found'
        );
    });
});

$app->run();
