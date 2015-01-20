<?php
use \LosLicense\License\License;

$conf = [
    'features' => [
        'numTest' => 20,
        'testFeature'
    ],
    'sign_license' => true,
    'license' => [
        'type' => License::LICENSE_TRIAL,
        'valid_from' => (new DateTime('-1 day'))->format('Y-m-d'),
        'valid_until' => (new DateTime('+1 day'))->format('Y-m-d'),
        'customer' => 'Leandro Silva',
        'features' => [
            'numTest' => 5,
            'testFeature'
        ],
        'attributes' => [
            'maxAtt' => 20,
            'testAtt'
        ],
        'signature' => 'e51703ef35f7ee5bd00afe3dabb2d6d0'
    ],
];

return [
    'loslicense' => $conf
];
