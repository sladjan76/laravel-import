<?php

return [

    'sign_up' => [
        'release_token' => env('SIGN_UP_RELEASE_TOKEN'),
        'validation_rules' => [
            'first_name' => 'sometimes|min:1,max:255|min:1,max:255',
            'last_name' => 'sometimes|min:1,max:255',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string'
        ]
    ],

    'login' => [
        'validation_rules' => [
            'email' => 'sometimes|email',
            'password' => 'sometimes|string'
        ]
    ],

    'forgot_password' => [
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    'reset_password' => [
        'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),
        'validation_rules' => [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ],

    'space_create' => [
        'validation_rules' => [
            'country_id' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'description' => 'required'
        ]
    ],

    'space_photos' => [
        'validation_rules' => [
            'photo' => 'required'
        ]
    ],

    'user_upload_path' => env('USER_UPLOAD_PATH'),
    'pet_upload_path' => env('PET_UPLOAD_PATH'),

    'twilio_sid' => env('TWILIO_SID'),
    'twilio_token' => env('TWILIO_TOKEN'),
    'twilio_number' => env('TWILIO_NUMBER'),
    'twilio_alphanumeric_id' => env('TWILIO_ALPHANUMERIC_ID'),
];
