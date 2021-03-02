<?php

declare(strict_types=1);

namespace Application\Delegators;

use Interop\Container\ContainerInterface;
use Laminas\EventManager\Event;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

use function call_user_func;

class IndexControllerDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $factory, ?array $options = null)
    {
        $realIndexController = call_user_func($factory);
        $eventManager        = $container->get('EventManager');
        $eventManager->attach('indexActionEvent', function (Event $event) {
            $eventName      = $event->getName();
            $params         = $event->getParams();
            $target         = $event->getTarget();
            $isPropaagation = $event->propagationIsStopped();
//            echo "Event :- $eventName fired. Stare at the art!\n";
        });

        return new IndexControllerDelegator($realIndexController, $eventManager);
    }
}
