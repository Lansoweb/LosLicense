<?php
use \LosLicense\License\License;

$conf = [
    'sign_license' => true,
    'license' => [
        'type' => License::LICENSE_TRIAL,
        'valid_from' => '2014-12-25 12:01:02',
        'valid_until' => '2014-12-30',
        'customer' => 'Leandro Silva',
        'features' => [
            'test'
        ],
        'signature' => '1f22f0199f9e9646a8dc59c6dd45d9d4'
    ],
];

return array(
    'loslicense' => $conf
);
