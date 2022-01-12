<?php

namespace MahmutBayri\FrameworkXCrud\Controllers;

use Clue\React\SQLite\Result;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class IndexTaskController
{
    /**
     * @param ServerRequestInterface $request
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return sqliteConnection()
            ->query(
                'SELECT * FROM tasks'
            )
            ->then(function (Result $result) {
                return new Response(
                    200,
                    [],
                    getTwig()->render('tasks/index.twig', [
                        'tasks' => $result->rows,
                    ])
                );
            });
    }
}
