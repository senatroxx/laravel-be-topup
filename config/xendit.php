<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Xendit Secret Key
    |--------------------------------------------------------------------------
    |
    | This value is secret key to accessing xendit service
    | Full documentation for xendit:
    |    https://developers.xendit.co/api-reference/
    |
     */

    'key' => env('XENDIT_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Xendit Invoice Duration
    |--------------------------------------------------------------------------
    |
    | This value is duration for invoice from xendit.
    | The value is in seconds
    |
     */

    'invoice_duration' => env('XENDIT_INVOICE_DURATION', '60'),

    /*
    |--------------------------------------------------------------------------
    | Xendit Redirect URL
    |--------------------------------------------------------------------------
    |
    | This value is a url for xendit so they can redirect the user to the
    | correct url. There are two types of redirect url:
    | - Success redirect url =  URL that the end customer will be redirected
    |                           to upon successful invoice payment.
    | - Failure redirect url =  URL that end user will be redirected to upon
    |                           expiration of this invoice.
    |
     */

    'success_redirect_url' => env('XENDIT_SUCCESS_REDIRECT_URL', ''),
    'failure_redirect_url' => env('XENDIT_FAILURE_REDIRECT_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Xendit Callback Token
    |--------------------------------------------------------------------------
    |
    | This value is a token to validate that a callback came from xendit server
    |
     */

    'callback_token' => env('XENDIT_CALLBACK_TOKEN', ''),
];
