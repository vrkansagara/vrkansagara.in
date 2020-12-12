<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterServiceFactory;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;

return [
    'db'              => [
        'driver' => 'Pdo',
        'dsn'    => sprintf('sqlite:%s/data/vrkansagara.sqlite3', realpath(getcwd())),

//        'driver' => 'Pdo',
//        'dsn' => 'mysql:dbname=vrkansagara.in;host=localhost',
        'driver_options' => [
            1002 => "SET NAMES 'UTF8'",
        ],
        'username'       => 'YOUR SECRET USER NAME',
        'password'       => 'YOUR SECRET PASSWORD',
    ],
    'service_manager' => [
        'factories' => [
            Adapter::class => AdapterServiceFactory::class,
        ],
    ],
    'session'         => [
        'config'     => [
            'class'   => SessionConfig::class,
            'options' => [
                'name' => 'session_name',
            ],
        ],
        'storage'    => SessionArrayStorage::class,
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ],
    ],
];
