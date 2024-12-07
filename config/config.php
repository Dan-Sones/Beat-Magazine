<?php

$env = $_ENV['APP_ENV'] ?? 'production'; // Default to 'production' if not set

if ($env === 'development') {
    define('BASE_PATH', dirname(__DIR__, 2)); // Adjust for local development
    define('PUBLIC_PATH', BASE_PATH . '/S246109-BeatMagazine/public');
} else {
    define('BASE_PATH', '/var/www');
    define('PUBLIC_PATH', BASE_PATH . '/httpdocs');
}
