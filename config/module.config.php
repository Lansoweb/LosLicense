<?php
return [
    'service_manager' => [
        'factories' => [
            'LosLicense\Validator\ValidatorPluginManager' => 'LosLicense\Validator\ValidatorPluginManagerFactory',
            'LosLicense\Validator\ControllerValidator' => 'LosLicense\Validator\ControllerValidatorFactory',
            'LosLicense\Validator\RouteValidator' => 'LosLicense\Validator\RouteValidatorFactory',
            'LosLicense\View\Strategy\TemplateStrategy' => 'LosLicense\View\Strategy\TemplateStrategyFactory',
            'LosLicense\View\Strategy\RedirectStrategy' => 'LosLicense\View\Strategy\RedirectStrategyFactory',
            'LosLicense\Service\ValidatorService' => 'LosLicense\Service\ValidatorServiceFactory',
            'LosLicense\License\License' => 'LosLicense\License\LicenseFactory',
            'LosLicense\Options\ModuleOptions' => 'LosLicense\Options\ModuleOptionsFactory',

            'LosLicense\Validator\Validators' => 'LosLicense\Validator\ValidatorsFactory',
        ],
        'aliases' => [
            'loslicense.license' => 'LosLicense\License\License',
            'loslicense.validator' => 'LosLicense\Service\ValidatorService',
            'loslicense.options' => 'LosLicense\Options\ModuleOptions',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'LosLicense\View\Helper\IsLicensed' => 'LosLicense\View\Helper\IsLicensedFactory',
            'LosLicense\View\Helper\hasFeature' => 'LosLicense\View\Helper\hasFeatureFactory',
        ],
        'aliases' => [
            'isLicensed' => 'LosLicense\View\Helper\IsLicensed',
            'hasFeature' => 'LosLicense\View\Helper\HasFeature',
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'LosLicense\Mvc\Controller\Plugin\IsLicensed' => 'LosLicense\Mvc\Controller\Plugin\IsLicensedFactory',
            'LosLicense\Mvc\Controller\Plugin\HasFeature' => 'LosLicense\Mvc\Controller\Plugin\HasFeatureFactory',
        ],
        'aliases' => [
            'isLicensed' => 'LosLicense\Mvc\Controller\Plugin\IsLicensed',
            'hasFeature' => 'LosLicense\Mvc\Controller\Plugin\HasFeature',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'LosLicense\Controller\Console' => 'LosLicense\Controller\ConsoleController',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'loslicense-create' => [
                    'options' => [
                        'route' => 'loslicense create [<outputFile>]',
                        'defaults' => [
                            '__NAMESPACE__' => 'LosLicense\Controller',
                            'controller' => 'Console',
                            'action' => 'create',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'LosLicense' => __DIR__.'/../view',
        ],
        'template_map' => [
            'error/403' => __DIR__.'/../view/los-license/error/403.phtml',
        ],
    ],
    'loslicense' => [
        'features' => [],
    ],
];
