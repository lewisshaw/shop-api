<?php
namespace Products\Action;

use Doctrine\Dbal\Connection;
use Interop\Container\ContainerInterface;

class GetProductFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetProduct($container->get(Connection::class));
    }
}
