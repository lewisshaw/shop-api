<?php
namespace Products\Action;

use Doctrine\Dbal\Connection;
use Interop\Container\ContainerInterface;

class GetProductsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetProducts($container->get(Connection::class));
    }
}
