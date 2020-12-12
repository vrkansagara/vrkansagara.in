<?php

namespace Application\Model\Factory;

use Application\Model\Search;
use Application\Model\SearchTable;
use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SearchTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): SearchTable
    {
        $dbAdapter          = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Search());
        $tableGateway = new TableGateway('search', $dbAdapter, null, $resultSetPrototype);

        return new SearchTable($tableGateway);
    }
}
