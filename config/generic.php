<?php

return [
    "APP_MIDDLEWARE_MODE" => env('APP_MIDDLEWARE_MODE', 'ndoptor.auth'),
    'DAK_PRIORITY_TYPE' => json_encode(array(0 => 'Choose Priority', 3 => 'High', 2 => 'Medium', 1 => 'Low')),
    'DAK_SECRECY_TYPE' => json_encode(array(0 => 'Choose Priority', 3 => 'High', 2 => 'Medium', 1 => 'Low')),
    "DAK_DAPTORIK" => 'Daptorik',
    "DAK_NAGORIK" => 'Nagorik',
];
