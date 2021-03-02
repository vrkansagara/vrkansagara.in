<?php

declare(strict_types=1);

namespace Page;

use Laminas\Router\Http\Literal;
use PhlySimplePage\PageController;

use function is_production_mode;

return [
    'router'       => [
        'routes' => [
            'page' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/page',
                    'defaults' => [
                        'controller' => PageController::class,
//                        'template' => 'page/resume',
                        'do_not_cache' => ! is_production_mode(),
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'blog'     => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/blog',
                            'defaults' => [
                                'controller'   => PageController::class,
                                'template'     => 'page/blog',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'mochikit' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/blog',
                            'defaults' => [
                                'controller'   => PageController::class,
                                'template'     => 'page/mochikit',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'about'    => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/about',
                            'defaults' => [
                                'controller'   => PageController::class,
                                'template'     => 'page/about',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'projects' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/projects',
                            'defaults' => [
                                'controller'   => PageController::class,
                                'template'     => 'page/projects',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'resume'   => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/resume',
                            'defaults' => [
                                'controller'   => PageController::class,
                                'template'     => 'page/resume',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'contact'  => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/contact',
                            'defaults' => [
                                'controller'   => PageController::class,
                                'template'     => 'page/contact',
                                'do_not_cache' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
