<?php
namespace LosLicense\Validator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ValidatorsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $validators        = [];

        /* @var \LosLicense\Options\ModuleOptions $options */
        $moduleOptions = $serviceLocator->get('loslicense.options');
        $pluginManager = $serviceLocator->get('LosLicense\Validator\ValidatorPluginManager');
        $service = $serviceLocator->get('loslicense.validator');

        if ($service->isLicensed()) {
            $validatorsOptions = $moduleOptions->getLicensedValidators();
        } else {
            $validatorsOptions = $moduleOptions->getUnlicensedValidators();
        }

        if (!empty($validatorsOptions)) {
            foreach ($validatorsOptions as $type => $options) {
                $validators[] = $pluginManager->get($type, $options);
            }
        }

        return $validators;
    }
}
