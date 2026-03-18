<?php

return [
    'api_key' => env('GEMINI_API_KEY', ''),
    'model' => env('GEMINI_MODEL', 'gemini-3-flash-preview'),
    'base_url' => 'https://generativelanguage.googleapis.com/v1beta',
];
