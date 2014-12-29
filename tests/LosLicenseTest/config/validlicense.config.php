<?php
use \LosLicense\License\License;

$conf = [
    'features' => [
        ['num_teste' => 20],
        'testFeature'
    ],
    'sign_license' => true,
    'license' => [
        'type' => License::LICENSE_TRIAL,
        'valid_from' => '2014-12-25 12:01:02',
        'valid_until' => '2014-12-30',
        'customer' => 'Leandro Silva',
        'features' => [
            ['num_teste' => 5],
            'teste'
        ],
        'attributes' => [
            ['max_att' => 20],
            'test_att'
        ],
        'signature' => 'ebe5db33b826f95f115c858a0a9bfcea'
    ],
];

return array(
    'loslicense' => $conf
);
