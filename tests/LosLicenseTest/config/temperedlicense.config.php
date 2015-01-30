<?php
use \LosLicense\License\LicenseInterface;

$conf = [
    'sign_license' => true,
    'license' => [
        'type' => LicenseInterface::LICENSE_TRIAL,
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
