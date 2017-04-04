<?php
namespace Cart\Action;

use Doctrine\Dbal\Connection;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetCart implements ServerMiddlewareInterface
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $cartId = $request->getAttribute('cartId');
        return new JsonResponse([
            'cartId' => 1234,
            'cart' => [
                'total' => '123.44',
                'products' => [
                    [
                        'title' => 'Computer',
                    ],
                    [
                        'title' => 'Laptop',
                    ],
                ]
            ],
        ]);
    }
}
