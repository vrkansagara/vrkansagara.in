<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Application\Model\SearchTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $applicationConfig = $container->get('config');

        $searchTable = $container->get(SearchTable::class);

        return new IndexController($applicationConfig, $searchTable);
    }
}
