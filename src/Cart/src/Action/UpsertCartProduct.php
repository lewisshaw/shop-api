<?php
namespace Cart\Action;

use Doctrine\Dbal\Connection;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UpsertCartProduct implements ServerMiddlewareInterface
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $cartId = md5(time() + rand(0, 100));
        $query = 'INSERT INTO Cart (cartId) VALUES (:cartId)';
        $this->dbConn->executeUpdate($query, ['cartId' => $cartId]);

        return new JsonResponse([
            'cartId' => $cartId,
        ]);
    }
}
