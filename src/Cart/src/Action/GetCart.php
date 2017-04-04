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

        $query = 'SELECT count(*) as cartFound FROM Cart where cartId = :cartId';
        $cartFound = $this->dbConn->fetchColumn($query, [':cartId' => $cartId]);
        if (!$cartFound) {
            $response = new JsonResponse([
                'error' => 'Cart not found',
            ]);
            return $response->withStatus(404);
        }

        $query = 'SELECT p.productId, p.title, p.price, cp.quantity
                    FROM Product as p
              INNER JOIN CartProduct as cp ON p.productId = cp.productId
                   WHERE cp.cartId = :cartId';

        $products = $this->dbConn->fetchAll($query, [':cartId' => $cartId]);

        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'];
        }
        $total = $total / 100;

        $products = array_map(function($product) {
            $product['price'] = $product['price'] / 100;
            return $product;
        }, $products);

        return new JsonResponse([
            'cartId' => $cartId,
            'cart' => [
                'total' => $total,
                'products' => $products,
            ],
        ]);
    }
}
