<?php
use \LosLicense\License\License;

$conf = [
    'template_strategy' => [
        'template' => 'error/403'
    ],
    'redirect_strategy' => [
        'redirect_to' => 'license-error'
    ],
    'unlicensed_mode' => 'whitelist',
    //'unlicensed_mode' => 'blacklist',
    'unlicensed_validators' => [
        /*'LosLicense\Validator\ControllerValidator' => [
            [
                'controller' => 'application\controller\index',
                'actions' => ['foo']
            ]
        ],*/
        'LosLicense\Validator\RouteValidator' => [
            'foo'
        ]
    ],
    'licensed_validators' => [
        /*'LosLicense\Validator\ControllerValidator' => [
            [
                'controller' => 'application\controller\index',
                'actions' => ['Foo'],
                'licenses' => [License::LICENSE_TRIAL],
                'features' => ['num_teste']
            ]
        ],*/
        'LosLicense\Validator\RouteValidator' => [
            'foo' => [
                'licenses' => [License::LICENSE_TRIAL],
                'features' => ['num_teste']
            ]
        ]
    ],
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
            'max_teste' => 20
        ],
        'signature' => '1f22f0199f9e9646a8dc59c6dd45d9d4'
    ],
];

return array(
    'loslicense' => $conf
);
