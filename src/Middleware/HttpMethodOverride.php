<?php

namespace MahmutBayri\FrameworkXCrud\Middleware;

use Psr\Http\Message\ServerRequestInterface;

/**
 * https://github.com/symfony/http-foundation/blob/6.1/Request.php#L1200
 */
class HttpMethodOverride
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $method = $request->getMethod();

        if ($method !== 'POST') {
            return $next($request);
        }

        $body = $request->getParsedBody();

        if (is_array($body) && isset($body['_method'])) {
            $method = $body['_method'];
        }

        if (\in_array($method, ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'PATCH', 'PURGE', 'TRACE'], true)) {
            return $next($request->withMethod($method));
        }

        return $next($request);
    }
}
