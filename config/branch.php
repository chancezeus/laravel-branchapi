<?php

return [
    'user_id' => env('BRANCH_USER_ID'),
    'key' => env('BRANCH_KEY'),
    'secret' => env('BRANCH_SECRET'),
    'test' => env('BRANCH_TEST_MODE', false),
    'key_test' => env('BRANCH_KEY_TEST'),
    'secret_test' => env('BRANCH_SECRET_TEST'),
];

