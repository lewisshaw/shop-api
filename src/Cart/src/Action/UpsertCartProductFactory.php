<?php
namespace Cart\Action;

use Doctrine\Dbal\Connection;
use Interop\Container\ContainerInterface;

class UpsertCartProductFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UpsertCartProduct($container->get(Connection::class));
    }
}
