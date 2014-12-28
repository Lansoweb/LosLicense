<?php
namespace LosLicense\Validator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LicensedValidatorsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \ZfcRbac\Options\ModuleOptions $options */
        $options       = $serviceLocator->get('loslicense.options');
        $validatorsOptions = $options->getLicensedValidators();

        if (empty($validatorsOptions)) {
            return [];
        }

        $pluginManager = $serviceLocator->get('LosLicense\Validator\ValidatorPluginManager');
        $validators        = [];

        foreach ($validatorsOptions as $type => $options) {
            $validators[] = $pluginManager->get($type, $options);
        }

        return $validators;
    }
}
