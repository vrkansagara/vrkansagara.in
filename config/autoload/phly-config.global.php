<?php

/**
 * This is a sample "local" configuration for your application. To use it, copy
 * it to your config/autoload/ directory of your application, and edit to suit
 * your application.
 *
 * This configuration example demonstrates using an SMTP mail transport, a
 * ReCaptcha CAPTCHA adapter, and setting the to and sender addresses for the
 * mail message.
 */

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Captcha\Dumb;
use Laminas\Mail\Transport\File;

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
        // This is simply configuration to pass to Laminas\Captcha\Factory
        'captcha' => [
            'class' => Dumb::class,
            'options' => [
                'pubkey' => 'RECAPTCHA_PUBKEY_HERE',
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

            'class' => File::class,
            'options' => [
                'path' => 'data/mail/',
            ],
        ],
    ],
];
