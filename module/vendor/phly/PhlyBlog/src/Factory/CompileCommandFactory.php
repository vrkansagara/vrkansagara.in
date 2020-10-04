<?php

namespace PhlyBlog\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\View;
use PhlyBlog\Command\CompileCommand;

class CompileCommandFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $controller = new CompileCommand();

        $config = $container->get('config')['blog'];
        $controller->setConfig($config);

        $controller->setView(new View());
        $eventManager = $container->get('EventManager');

        $controller->setEventManager($eventManager);

        return $controller;
    }
}
