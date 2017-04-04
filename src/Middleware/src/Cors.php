<?php
namespace Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Delegate\NotFoundDelegate;

class Cors implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = $delegate->process($request);

        $response = $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:1234');
        $response = $response->withHeader('Access-Control-Allow-Headers', 'Content-Type');
        return $response;
    }
}
