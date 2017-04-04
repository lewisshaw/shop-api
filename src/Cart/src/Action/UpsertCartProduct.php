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
        $cartId = $request->getAttribute('cartId');
        $product = json_decode($request->getBody(), true);
        if (!isset($product['productId']) || !isset($product['quantity'])) {
            $response = new JsonResponse([
                'error' => 'Invalid request',
            ]);
            return $response->withStatus(400);
        }
        $productId = $product['productId'];
        $quantity  = $product['quantity'];

        $query = 'SELECT count(*) as cartFound FROM Cart where cartId = :cartId';
        $cartFound = $this->dbConn->fetchColumn($query, [':cartId' => $cartId]);
        if (!$cartFound) {
            $response = new JsonResponse([
                'error' => 'Cart not found',
            ]);
            return $response->withStatus(404);
        }

        if ($quantity <= 0) {
            $query = 'DELETE FROM CartProduct WHERE cartId = :cartId and productId = :productId';
            $this->dbConn->executeUpdate($query, [':cartId' => $cartId, ':productId' => $productId]);
            return new JsonResponse([
                'cartId' => $cartId,
                'productId' => $productId,
                'quantity' => 0,
            ]);
        }

        $cartProductExists = $this->dbConn->fetchColumn(
            'SELECT count(*) FROM CartProduct where cartId = :cartId AND productId = :productId',
            [':productId' => $productId, ':cartId' => $cartId]
        );
        if ($cartProductExists) {
            $query = 'UPDATE CartProduct SET quantity = :quantity
                       WHERE productId = :productId and cartId = :cartId';

            $this->dbConn->executeUpdate($query, [':quantity' => $quantity, ':productId' => $productId, ':cartId' => $cartId]);
            return new JsonResponse([
                'cartId' => $cartId,
                'productId' => $productId,
                'quantity' => $quantity,
            ]);
        }
        $query = 'INSERT INTO CartProduct (cartId, productId, quantity)
                       VALUES (:cartId, :productId, :quantity)';
        $this->dbConn->executeUpdate($query, [
            ':cartId' => $cartId,
            ':productId' => $productId,
            ':quantity' => $quantity,
        ]);

        return new JsonResponse([
            'cartId' => $cartId,
            'productId' => $productId,
            'quantity' => $quantity,
        ]);
    }
}
