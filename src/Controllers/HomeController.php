<?php

namespace MahmutBayri\FrameworkXCrud\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class HomeController
{
    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return new Response(
            200,
            [],
            getTwig()->render('home.twig')
        );
    }
}
