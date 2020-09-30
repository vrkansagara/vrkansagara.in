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

return [
    'phly-simple-page' => [
        'cache' => [
            'adapter' => [
                'name'   => 'filesystem',
                'options' => [
                    'namespace'       => 'pages',
                    'cache_dir'       => getcwd() . '/data/cache',
                    'dir_permission'  => '0777',
                    'file_permission' => '0666',
                ],
            ],
        ],
    ],
];
