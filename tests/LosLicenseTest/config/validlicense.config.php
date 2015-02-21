<?php
use \LosLicense\License\LicenseInterface;

$conf = [
    'features' => [
        'numTest' => 20,
        'testFeature'
    ],
    'sign_license' => true,
    'license' => [
        'type' => LicenseInterface::LICENSE_TRIAL,
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
        'signature' => '49e54ff88f1ee125cd39f61a8e1bcb32'
    ],
];

return [
    'loslicense' => $conf
];
