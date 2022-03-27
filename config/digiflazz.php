<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Digiflazz Webhook ID
    |--------------------------------------------------------------------------
    |
    | This value is id to identify request from digiflazz.
    |
     */
    'webhook_id' => env('DIGIFLAZZ_WEBHOOK_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Digiflazz API Username
    |--------------------------------------------------------------------------
    |
    | This value is username of your api credentials from digiflazz. You can
    | get it from https://member.digiflazz.com/buyer-area/connection/api
    |
     */
    'username' => env('DIGIFLAZZ_USERNAME', null),

    /*
    |--------------------------------------------------------------------------
    | Digiflazz Secret Key
    |--------------------------------------------------------------------------
    |
    | This value is secret to identify signature header of request from digiflazz.
    |
     */
    'secret' => env('DIGIFLAZZ_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Digiflazz Development Key
    |--------------------------------------------------------------------------
    |
    | This value is development key of your api credentials from digiflazz.
    | All transaction will be done in development mode.
    |
     */
    'dev_key' => env('DIGIFLAZZ_DEV_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Digiflazz Production Key
    |--------------------------------------------------------------------------
    |
    | This value is production key of your api credentials from digiflazz.
    | All transaction will be done in production mode.
    |
     */
    'prod_key' => env('DIGIFLAZZ_PROD_KEY', null),
];
