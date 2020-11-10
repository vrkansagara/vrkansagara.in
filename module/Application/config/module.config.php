<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\IndexController;
use Application\Model\Factory\SearchTableFactory;
use Application\Model\SearchTable;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use PhlySimplePage\ClearCacheCommand;
use PhlySimplePage\PageCacheFactory;

return [
    'laminas-cli' => [
        'commands' => [
            'cache:clear' => ClearCacheCommand::class,
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
//                        'controller' => PageController::class,
//                        'template' => 'application/index/index',
                        'do_not_cache' => ! is_production_mode(),
//                        'middleware' => XClacksOverheadMiddleware::class,
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                ],
            ],
            'search' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/s',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'search',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
        'delegators' => [
//            IndexController::class => [
//                IndexControllerDelegatorFactory::class,
//            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            SearchTable::class => SearchTableFactory::class,
            'PhlySimplePage\PageCache' => PageCacheFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'base_path' => '/',
        'template_map' => [
            'layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'phly-contact/contact/index' => __DIR__ . '/../view/phly-contact/contact/index.phtml',
            'phly-contact/contact/thank-you' => __DIR__ . '/../view/phly-contact/contact/thank-you.phtml',
            'application/delegators/index-controller-delegator/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/delegators/index-controller-delegator/search' => __DIR__ . '/../view/application/index/search.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\AccessPlugin::class => InvokableFactory::class,
        ],
        'aliases' => [
            'access' => Controller\Plugin\AccessPlugin::class,
        ]
    ]
];
