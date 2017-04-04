<?php
namespace Database;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ConnectionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbalConfig = new Configuration();

        $config = $container->get('config');

        if (!isset($config['dbal'])) {
            throw new \Exception('Missing key dbal in config');
        }

        return DriverManager::getConnection($config['dbal'], $dbalConfig);
    }
}
