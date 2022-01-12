<?php

namespace MahmutBayri\FrameworkXCrud\Controllers;

use Clue\React\SQLite\Result;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class DestroyTaskController
{
    /**
     * @param ServerRequestInterface $request
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        return sqliteConnection()
            ->query(
                'DELETE FROM tasks WHERE id = ?',
                [$id]
            )
            ->then(function (Result $result) {
                return new Response(
                    301,
                    [
                        'Location' => '/tasks'
                    ],
                    $result->changed ? 'deleted' : 'not found'
                );
            });
    }
}
