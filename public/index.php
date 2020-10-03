<?php

declare(strict_types=1);

use Laminas\Mvc\Application;
use Laminas\Stdlib\ArrayUtils;

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Do 301 rewrites
include __DIR__ . '/../rewrites.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    // Retrieve configuration
    $appConfig = require __DIR__ . '/../config/application.config.php';
    if (file_exists(__DIR__ . '/../config/development.config.php')) {
        $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
    }

// Run the application!
    Application::init($appConfig)->run();
})();
