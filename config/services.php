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
        'client_id' => '1572256699473093',
        'client_secret' => 'e7c7bdf74d72c1b3f61cc293d380ecb8',
        'redirect' => 'http://lar.dev/ITJob/public/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '944515654602-jj757r6sbtam54ie92tj7vto10o4tm6c.apps.googleusercontent.com',
        'client_secret' => '5J5DPDNKzgZGQxxm4Az-1Zkj',
        'redirect' => 'http://lar.dev/ITJob/public/login/google/callback',
    ],

];
