<?php


use Crawler\Command\InfoCommand;
use Crawler\Command\StartCommand;

return [
    'crawler' => [
        // Module specific configuration
    ],
    'laminas-cli' => [
        'commands' => array(
            'crawler:info' => InfoCommand::class,
            'crawler:start' => StartCommand::class,
        ),
    ],
];