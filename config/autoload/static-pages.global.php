<?php

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use PhlySimplePage\PageController;

return [
    'router' => [
        'routes' => [
            'page' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/page',
                    'defaults' => [
                        'controller' => PageController::class,
//                        'template' => 'page/resume',
                        'do_not_cache' => ! is_production_mode(),
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'blog' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/blog',
                            'defaults' => [
                                'controller' => PageController::class,
                                'template' => 'page/blog',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'mochikit' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/blog',
                            'defaults' => [
                                'controller' => PageController::class,
                                'template' => 'page/mochikit',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'about' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/about',
                            'defaults' => [
                                'controller' => PageController::class,
                                'template' => 'page/about',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'projects' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/projects',
                            'defaults' => [
                                'controller' => PageController::class,
                                'template' => 'page/projects',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'resume' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/resume',
                            'defaults' => [
                                'controller' => PageController::class,
                                'template' => 'page/resume',
                                'do_not_cache' => ! is_production_mode(),
                            ],
                        ],
                    ],
                    'contact' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/contact',
                            'defaults' => [
                                'controller' => PageController::class,
                                'template' => 'page/contact',
                                'do_not_cache' => true,
                            ],
                        ],
                    ]
                ]
            ],
        ]
    ]
];
