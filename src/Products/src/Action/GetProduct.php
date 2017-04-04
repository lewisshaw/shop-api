<?php
namespace Products\Action;

use Doctrine\Dbal\Connection;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetProduct implements ServerMiddlewareInterface
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $productId = $request->getAttribute('productId');

        if (!$productId) {
            $response = new JsonResponse([
                'error' => 'Product not found',
            ]);
            return $response->withStatus(404);
        }

        $query = 'SELECT productId, title, description, price FROM Product WHERE productId = :productId';

        $product = $this->dbConn->fetchAssoc($query, [':productId' => $productId]);

        if (!$product) {
            $response = new JsonResponse([
                'error' => 'Product not found',
            ]);
            return $response->withStatus(404);
        }

        $product['price'] = $product['price'] / 100;

        return new JsonResponse($product);
    }
}
