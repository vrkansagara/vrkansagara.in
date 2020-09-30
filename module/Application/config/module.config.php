<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Captcha\Dumb;
use Laminas\DevelopmentMode\Command;
use Laminas\Mail\Transport\File;
use Laminas\Mail\Transport\Smtp;
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
                    'cache_dir' => getcwd() . '/data/cache',
                    'dir_permission' => '0777',
                    'file_permission' => '0666',
                ],
            ],
        ],
    ],
    'phly_contact' => [
        // This is simply configuration to pass to Zend\Captcha\Factory
        'captcha' => [
            'class'   => Dumb::class,
            'options' => [
                'pubkey'  => 'RECAPTCHA_PUBKEY_HERE',
                'privkey' => 'RECAPTCHA_PRIVKEY_HERE',
            ],
        ],

        // This sets the default "to" and "sender" headers for your message
        'message' => [
            /*
            // These can be either a string, or an array of email => name pairs
            'to'     => 'contact@your.tld',
            'from'   => 'contact@your.tld',
            // This should be an array with minimally an "address" element, and
            // can also contain a "name" element
            'sender' => array(
                'address' => 'contact@your.tld'
            ),
             */
        ],

        // Transport consists of two keys:
        // - "class", the mail tranport class to use, and
        // - "options", any options to use to configure the
        //   tranpsort. Usually these will be passed to the
        //   transport-specific options class
        // This example configures GMail as your SMTP server
        'mail_transport' => [
//            'class'   => Smtp::class,
//            'options' => [
//                'host'             => 'smtp.gmail.com',
//                'port'             => 587,
//                'connectionClass'  => 'login',
//                'connectionConfig' => [
//                    'ssl'      => 'tls',
//                    'username' => 'contact@your.tld',
//                    'password' => 'password',
//                ],
//            ],

            'class'   => File::class,
            'options' => [
                'path' => 'data/mail/',
            ],
        ],
    ],
    'laminas-cli' => [
        'commands' => [
            'cache:clear' => ClearCacheCommand::class,
            'blog:compile ' => CompileController::class,

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
            's' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/?s=',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'search',
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
                        'do_not_cache' => true,
                    ],
                ],
            ],
//            'contact' => [
//                'type' => Literal::class,
//                'options' => [
//                    'route' => '/contact',
//                    'defaults' => [
//                        'controller' => PageController::class,
//                        'template' => 'application/pages/contact',
//                        // optionally set a specific layout for this page
////                        'layout'     => 'layout/some-layout',
//                        'do_not_cache' => true,
//                    ],
//                ],
//            ],
            'projects' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/projects',
                    'defaults' => [
                        'controller' => PageController::class,
                        'template' => 'application/pages/projects',
                        // optionally set a specific layout for this page
//                        'layout'     => 'layout/some-layout',
                        'do_not_cache' => true,
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
                        'do_not_cache' => true,
                    ],
                ],
            ],
            'blog' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => PageController::class,
                        'template' => 'application/pages/blog',
                        // optionally set a specific layout for this page
//                        'layout'     => 'layout/some-layout',
                        'do_not_cache' => true,
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
