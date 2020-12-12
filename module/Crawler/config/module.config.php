<?php

use Crawler\Command\InfoCommand;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'crawler'         => [
        // Module specific configuration
    ],
    'laminas-cli'     => [
//        'commands' => array(
//            'crawler:info' => InfoCommand::class,
//            'crawler:start' => StartCommand::class,
//        ),
    ],
    'service_manager' => [
        'factories' => [
            InfoCommand::class => InvokableFactory::class,
        ],
    ],
];
