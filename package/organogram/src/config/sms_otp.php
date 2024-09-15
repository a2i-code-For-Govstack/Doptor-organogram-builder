<?php
return [
    'sms_api_url' => env('SMS_GATEWAY_URL', ''),
    'sms_api_user' => env('SMS_GATEWAY_USER', ''),
    'sms_api_pass' => env('SMS_GATEWAY_PASS', ''),
    'sms_api_a_code' => env('SMS_GATEWAY_A_CODE', ''),
    'sms_api_masking' => env('SMS_GATEWAY_MASKING', ''),
];
