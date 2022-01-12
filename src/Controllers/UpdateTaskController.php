<?php

namespace MahmutBayri\FrameworkXCrud\Controllers;

use Clue\React\SQLite\Result;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class UpdateTaskController
{
    /**
     * @param ServerRequestInterface $request
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $fields = $request->getParsedBody();

        return sqliteConnection()
            ->query(
                'UPDATE tasks SET title = ? WHERE id = ?',
                [$fields['title'], $id]
            )
            ->then(function (Result $result) use ($id) {
                return new Response(
                    301,
                    [
                        'Location' => '/tasks/' . $id
                    ],
                    $result->changed ? 'updated' : 'not found'
                );
            });
    }
}
