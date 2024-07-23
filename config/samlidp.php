<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SAML idP configuration file
    |--------------------------------------------------------------------------
    |
    | Use this file to configure the service providers you want to use.
    |
     */
    // Outputs data to your laravel.log file for debugging
    'debug' => true,
    // Define the email address field name in the users table
    'email_field' => 'email',
    'name_field' => 'username',
    // The URI to your login page
    'login_uri' => 'login',
    // Log out of the IdP after SLO
    'logout_after_slo' => env('LOGOUT_AFTER_SLO', false),
    // The URI to the saml metadata file, this describes your idP
    'issuer_uri' => 'saml/metadata',
    // Name of the certificate PEM file
    'certname' => 'cert.pem',
    // Name of the certificate key PEM file
    'keyname' => 'key.pem',
    // Encrypt requests and responses
    'encrypt_assertion' => true,
    // Make sure messages are signed
    'messages_signed' => true,
    // Defind what digital algorithm you want to use
    'digest_algorithm' => \RobRichards\XMLSecLibs\XMLSecurityDSig::SHA1,
    // list of all service providers
    'sp' => [
            env('SAML_WORDPRESS_BASE64_URL', false) => [ // aHR0cHM6Ly9kcm9pZGJ1aWxkZXJzLnVrLw==
            //     // Your destination is the ACS URL of the Service Provider
            'destination' => env('SAML_WORDPRESS_DESTINATION', false), // 'https://fr.60chequersavenue.net/saml/sso',
            'logout' => env('SAML_WORDPRESS_LOGOUT', false), // 'https://fr.60chequersavenue.net/saml/slo',
            //    // SP certificate
            'certificate' => '',
            //    // Turn off auto appending of the idp query param
            'query_params' => false,
            //    // Turn off the encryption of the assertion per SP
            'encrypt_assertion' => false
            // ]
            ],
            env('SAML_WORDPRESS391_BASE64_URL', false) => [ // aHR0cHM6Ly9kcm9pZGJ1aWxkZXJzLnVrLw==
            //     // Your destination is the ACS URL of the Service Provider
            'destination' => env('SAML_WORDPRESS391_DESTINATION', false), // 'https://fr.60chequersavenue.net/saml/sso',
            'logout' => env('SAML_WORDPRESS391_LOGOUT', false), // 'https://fr.60chequersavenue.net/saml/slo',
            //    // SP certificate
            'certificate' => '',
            //    // Turn off auto appending of the idp query param
            'query_params' => false,
            //    // Turn off the encryption of the assertion per SP
            'encrypt_assertion' => false
            // ]
            ]
    ],

    // If you need to redirect after SLO depending on SLO initiator
    // key is beginning of HTTP_REFERER value from SERVER, value is redirect path
    'sp_slo_redirects' => [
        // 'https://example.com' => 'https://example.com',
    ],

    // All of the Laravel SAML IdP event / listener mappings.
    'events' => [
        'CodeGreenCreative\SamlIdp\Events\Assertion' => [],
        'Illuminate\Auth\Events\Logout' => ['CodeGreenCreative\SamlIdp\Listeners\SamlLogout'],
        'Illuminate\Auth\Events\Authenticated' => ['CodeGreenCreative\SamlIdp\Listeners\SamlAuthenticated'],
        'Illuminate\Auth\Events\Login' => ['CodeGreenCreative\SamlIdp\Listeners\SamlLogin'],
    ],

    // List of guards saml idp will catch Authenticated, Login and Logout events
    'guards' => ['web'],

];
