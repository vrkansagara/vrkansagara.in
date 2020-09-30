<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    // The "init" method is called on application start-up and
    // allows to register an event listener.
    public function init(ModuleManager $manager)
    {
        // Get event manager.
        $eventManager = $manager->getEventManager();

//        $sharedEventManager = $eventManager->getSharedManager();
        // Register the event listener method.
//        $sharedEventManager->attach(__NAMESPACE__, 'dispatch',
//            [$this, 'onDispatch'], 100);
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $eventManager = $application->getEventManager();
//        $config      = $application->getConfig();
//        $view        = $application->getServiceManager()->get('ViewHelperManager');
//        // You must have these keys in you application config
//        $view->headTitle($config['view']['base_title']);
//
//        // This is your custom listener
//        $listener   = new Listeners\ViewListener();
//        $listener->setView($view);
//        $application->getEventManager()->attachAggregate($listener);

        $eventManager->attach(MvcEvent::EVENT_FINISH, function ($e) {
            $time = microtime(true) - REQUEST_MICROTIME;

            // formatting time to be more friendly
            if ($time <= 60) {
                $timeF = number_format($time, 2, ',', '.') . 's'; // conversion to seconds
            } else {
                $resto  = fmod($time, 60);
                $minuto = number_format($time / 60, 0);
                $timeF = sprintf('%dm%02ds', $minuto, $resto); // conversion to minutes and seconds
            }

            // Search static content and replace for execution time
            $response = $e->getResponse();
            $response->setContent(str_replace(
                'Execution time:',
                'Execution time: ' . $timeF,
                $response->getContent()
            ));
        }, 100000);
    }


    // Event listener method.
    public function onDispatch(MvcEvent $event)
    {
        // Get controller to which the HTTP request was dispatched.
//        $controller = $event->getTarget();
        // Get fully qualified class name of the controller.
//        $controllerClass = get_class($controller);
        // Get module name of the controller.
//        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));

        // Switch layout only for controllers belonging to our module.
//        if ($moduleNamespace == __NAMESPACE__) {
//            $viewModel = $event->getViewModel();
//            $viewModel->setTemplate('layout/layout2');
//        }
    }
}
