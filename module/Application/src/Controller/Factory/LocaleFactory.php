<?php

namespace Application\Controller\Factory;

use Application\Controller\LocaleController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LocaleFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        // The $container variable is the service manager.
        $sessionContainer = $container->get('ApplicationSessionContainer');

        $translator = $container->get('MvcTranslator');

        return new LocaleController($translator, $sessionContainer);
    }
}
