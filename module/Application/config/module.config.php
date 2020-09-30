<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use PhlyBlog\CompileController;
use PhlySimplePage\ClearCacheCommand;
use PhlySimplePage\PageCacheFactory;
use PhlySimplePage\PageController;

return [
    'phly-simple-page' => [
        'cache' => [
            'adapter' => [
                'name' => Filesystem::class,
                'options' => [
                    'namespace' => 'pages',
                    'cache_dir' => getcwd() . '/data/cache/static-page-data',
                    'dir_permission' => '0777',
                    'file_permission' => '0666',
                ],
            ],
        ],
    ],
    'laminas-cli' => [
        'commands' => [
            'cache:clear' => ClearCacheCommand::class,
            'blog:compile ' => CompileController::class

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
            ],
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/about',
                    'defaults' => [
                        'controller' => PageController::class,
                        'template' => 'application/pages/about',
                        // optionally set a specific layout for this page
//                        'layout'     => 'layout/some-layout',
                        'do_not_cache' => false,
                    ],
                ],
            ],
            'contact' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        'controller' => PageController::class,
                        'template' => 'application/pages/contact',
                        // optionally set a specific layout for this page
//                        'layout'     => 'layout/some-layout',
                        'do_not_cache' => false,
                    ],
                ],
            ],
            'projects' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/projects',
                    'defaults' => [
                        'controller' => PageController::class,
                        'template' => 'application/pages/projects',
                        // optionally set a specific layout for this page
//                        'layout'     => 'layout/some-layout',
                        'do_not_cache' => false,
                    ],
                ],
            ],
            'resume' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/resume',
                    'defaults' => [
                        'controller' => PageController::class,
                        'template' => 'application/pages/resume',
                        // optionally set a specific layout for this page
//                        'layout'     => 'layout/some-layout',
                        'do_not_cache' => false,
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'PhlySimplePage\PageCache' => PageCacheFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
