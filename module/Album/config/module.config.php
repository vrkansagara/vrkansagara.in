<?php

declare(strict_types=1);

namespace Album;

use Laminas\Router\Http\Segment;

return [
    'navigation'      => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Album',
                'route' => 'album',
                'pages' => [
                    [
                        'label'  => 'Add',
                        'route'  => 'album',
                        'action' => 'add',
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'album',
                        'action' => 'edit',
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'album',
                        'action' => 'delete',
                    ],
                ],
            ],
        ],
    ],
    'router'          => [
        'routes' => [
            'album'     => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'album-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/api/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => Api\AlbumController::class,
                    ],
                ],
            ],
        ],
    ],
    'controllers'     => [
        'factories' => [
//            AlbumController::class => InvokableFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
//            'Model\AlbumTableGateway' => AlbumTableFactory::class
        ],
    ],
    'view_manager'    => [
        'template_map'        => [],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
