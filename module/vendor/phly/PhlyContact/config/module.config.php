<?php

return [
    'phly_contact' => [
        'captcha' => [
            'class' => 'dumb',
        ],
        'form' => [
            'name' => 'contact',
        ],
        'mail_transport' => [
            'class' => 'Zend\Mail\Transport\Sendmail',
            'options' => [
            ]
        ],
        'message' => [
            /*
            'to' => array(
                'EMAIL HERE' => 'NAME HERE',
            ),
            'sender' => array(
                'address' => 'EMAIL HERE',
                'name'    => 'NAME HERE',
            ),
            'from' => array(
                'EMAIL HERE' => 'NAME HERE',
            ),
             */
        ],
    ],
    'controllers' => [
        'factories' => [
            'PhlyContact\Controller\Contact' => 'PhlyContact\Service\ContactControllerFactory',
        ],
    ],
    'router' => [
        'routes' => [
            'contact' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        '__NAMESPACE__' => 'PhlyContact\Controller',
                        'controller'    => 'Contact',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'process' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/process',
                            'defaults' => [
                                'action' => 'process',
                            ],
                        ],
                    ],
                    'thank-you' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/thank-you',
                            'defaults' => [
                                'action' => 'thank-you',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'PhlyContactCaptcha'       => 'PhlyContact\Service\ContactCaptchaFactory',
            'PhlyContactForm'          => 'PhlyContact\Service\ContactFormFactory',
            'PhlyContactMailMessage'   => 'PhlyContact\Service\ContactMailMessageFactory',
            'PhlyContactMailTransport' => 'PhlyContact\Service\ContactMailTransportFactory',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'phly-contact/contact/index'     => __DIR__ . '/../view/phly-contact/contact/index.phtml',
            'phly-contact/contact/thank-you' => __DIR__ . '/../view/phly-contact/contact/thank-you.phtml',
        ],
        'template_path_stack' => [
            'phly-contact' => __DIR__ . '/../view',
        ],
    ],
];
