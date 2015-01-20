<?php
use \LosLicense\License\License;

$conf = [
    'sign_license' => true,
    'license' => [
        'type' => License::LICENSE_TRIAL,
        'customer' => 'Leandro Silva',
        'features' => [
            'test'
        ],
        'signature' => '1f22f0199f9e9646a8dc59c6dd45d9d4'
    ],
];

return [
    'loslicense' => $conf
];
