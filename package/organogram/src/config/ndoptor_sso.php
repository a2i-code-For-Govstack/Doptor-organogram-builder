<?php

return [
    'sso_base_url' => env('SSO_BASE_URL', 'http://192.168.122.133:9090'),
    'sso_realm' => env('SSO_REALM', 'ndoptor'),
    'sso_client_id' => env('SSO_CLIENT_ID', 'ndoptor-admin-local'),
    'sso_client_url' => env('APP_URL', 'http://localhost:8000'),
];
