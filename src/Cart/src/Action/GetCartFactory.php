<?php
namespace Cart\Action;

use Doctrine\Dbal\Connection;
use Interop\Container\ContainerInterface;

class GetCartFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetCart($container->get(Connection::class));
    }
}
