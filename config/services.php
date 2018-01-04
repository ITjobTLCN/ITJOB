<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1696540260403984',
        'client_secret' => '4f2b9bed29bd4130850af0b0edfb21df',
        'redirect' => 'http://itjob.localhost/public/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '944515654602-jj757r6sbtam54ie92tj7vto10o4tm6c.apps.googleusercontent.com',
        'client_secret' => '5J5DPDNKzgZGQxxm4Az-1Zkj',
        'redirect' => 'http://itjob.localhost/public/login/google/callback',
    ],

];
