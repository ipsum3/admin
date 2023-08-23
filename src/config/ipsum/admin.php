<?php

return [

    'route_prefix' => 'administration',

    'user_model' => Ipsum\Admin\app\Models\Admin::class,

    'guard' => 'ipsumAdmin',

    // The classes for the middleware to check if the visitor is an admin
    'middlewares' => [
        'adminAuth',
    ],


    'roles' => array(
        '1' => 'Super administrateur',
        '2' => 'Administrateur',
        '3' => 'Éditeur',
    ),


    'acces' => array(
        'article' => 'Article',
        'media' => 'Médias',
        'parametres' => 'Paramètres',
    ),

    'assets_path' => base_path().'/vendor/ipsum3/admin-assets/dist',

    'remove_evil_html_tags' => array(
        'iframe',
        'button'
    )
];
