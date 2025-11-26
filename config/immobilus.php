<?php

return [
    'brand' => [
        'name' => env('IMMO_NAME', 'Immobilus'),
        'logo' => env('IMMO_LOGO', 'frontend/assets/images/logo.png'),
    ],

    'contact' => [
        'address' => env('IMMO_ADDRESS', 'Conakry, Guinée'),
        'phone'   => env('IMMO_PHONE', '+224 620 00 00 00'),
        'email'   => env('IMMO_EMAIL', 'contact@immobilus.gn'),
        'hours'   => env('IMMO_HOURS', 'Lun - Sam 9:00 - 18:00'),
    ],

    'social' => [
        'facebook'  => env('IMMO_FB', '#'),
        'twitter'   => env('IMMO_TW', '#'),
        'instagram' => env('IMMO_IG', '#'),
        'linkedin'  => env('IMMO_IN', '#'),
    ],

    'home' => [
        'banner_title'    => env('IMMO_BANNER_TITLE', 'Trouvez votre bien en Guinée'),
        'banner_subtitle' => env('IMMO_BANNER_SUB', 'Acheter, vendre ou louer en toute confiance'),
    ],
];
