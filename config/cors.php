<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Include sanctum/csrf-cookie if using Sanctum
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173', 'http://example.com'], // Added localhost variations
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Changed to true to support credentials
];