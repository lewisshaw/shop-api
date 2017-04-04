<?php
namespace Products\Action;

use Doctrine\Dbal\Connection;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetProducts implements ServerMiddlewareInterface
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $query = 'SELECT productId, title, description, price FROM Product';

        $products = $this->dbConn->fetchAll($query);

        $products = array_map(function($product) {
            $product['price'] = $product['price'] / 100;
            return $product;
        }, $products);

        return new JsonResponse($products);
    }
}
