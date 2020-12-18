<?php

namespace Blog\Factory;

use Application\Module;
use Application\View\Helper\Disqus;
use Laminas\Config\Config;
use Laminas\Mvc\Application;
use Laminas\Mvc\Service\ViewHelperManagerFactory;
use Laminas\View\HelperPluginManager;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\View;
use Laminas\View\ViewEvent;
use Psr\Container\ContainerInterface;

use function method_exists;
use function str_replace;

class PhlyBlogViewFactory
{
    public function __invoke(ContainerInterface $container): View
    {
        // This part is necessary to ensure that the router and MvcEvent are
        // populated for helpers such as the Url helper.
        $application = $container->get('Application');
        if ($application instanceof Application) {
            $application->bootstrap();
        }

        // Prepare the initial view state
        $view = $container->get(View::class);

        /** @var RendererInterface $renderer */
        $renderer = $container->get(RendererInterface::class);

        // Reset the helper plugin manager on each iteration
        $view->addRenderingStrategy(function () use ($container, $renderer) {
            if (method_exists($renderer, 'setHelperPluginManager')) {
                /** @param HelperPluginManager $helper */
                $helper = (new ViewHelperManagerFactory())($container, 'ViewHelperManager');
                $helper->setFactory('disqus', function ($serviceManager) {
                    $config = $serviceManager->get('config');
                    if ($config instanceof Config) {
                        $config = $config->toArray();
                    }
                    $config = $config['disqus'];
                    return new Disqus($config);
                });
                $renderer->setHelperPluginManager($helper);
            }
            return $renderer;
        }, 100);

        // Create the layout view model
        $config = $container->get('config');
        $layout = new ViewModel();
        $layout->setTemplate($config['view_manager']['layout'] ?? 'layout/layout');

        // Render content within the layout
        $view->addResponseStrategy(function (ViewEvent $viewEvent) use ($renderer, $layout) {
            $layout->setVariable('content', $viewEvent->getResult());
            $response = str_replace('Execution time:', '', $renderer->render($layout));
            // Compress code.
            $response = Module::compress($response);
            $viewEvent->setResult($response);
        }, 100);

        return $view;
    }
}
