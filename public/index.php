<?php

require __DIR__ . '/../bootstrap.php';

use MahmutBayri\FrameworkXCrud\Controllers\{
    DestroyTaskController,
    EditTaskController,
    HomeController,
    IndexTaskController,
    CreateTaskController,
    ShowTaskController,
    StoreTaskController,
    UpdateTaskController
};

use MahmutBayri\FrameworkXCrud\Middleware\HttpMethodOverride;

$app = new FrameworkX\App(new HttpMethodOverride());

// Home
$app->get('/', new HomeController());

// Index
$app->get('/tasks', new IndexTaskController());

// create
$app->get('/tasks/create', new CreateTaskController());

// store
$app->post('/tasks', new StoreTaskController());

// show
$app->get('/tasks/{id}', new ShowTaskController());

// edit
$app->get('/tasks/{id}/edit', new EditTaskController());

// update
$app->put('/tasks/{id}', new UpdateTaskController());

// destroy
$app->delete('/tasks/{id}', new DestroyTaskController());

// It runs every 30 minutes to reset db.
resetMigration();

$app->run();
