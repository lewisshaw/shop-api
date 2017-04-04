<?php
namespace Cart\Action;

use Doctrine\Dbal\Connection;
use Interop\Container\ContainerInterface;

class CreateCartFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CreateCart($container->get(Connection::class));
    }
}
