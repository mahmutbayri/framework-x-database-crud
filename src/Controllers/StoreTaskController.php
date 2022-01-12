<?php

namespace MahmutBayri\FrameworkXCrud\Controllers;

use Clue\React\SQLite\Result;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class StoreTaskController
{
    /**
     * @param ServerRequestInterface $request
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $fields = $request->getParsedBody();

        return sqliteConnection()
            ->query('INSERT INTO tasks (title) VALUES (?)', [$fields['title']])
            ->then(
                function (Result $result) {
                    return new Response(
                        301,
                        [
                            'Location' => '/tasks/' . $result->insertId
                        ],
                        'inserted' . $result->changed
                    );
                },
                function (\Exception $e) {
                    return new Response(
                        200,
                        [],
                        'Error: ' . $e->getMessage() . PHP_EOL
                    );
                }
            );
    }
}
