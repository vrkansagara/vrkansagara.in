<?php


namespace Crawler\Command\Factory;


use Crawler\Command\InfoCommand;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;

class InfoCommandFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : InfoCommand
    {
        return new InfoCommand($container->get('crawler'));
    }
}