<?php
namespace LosLicense\Validator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ValidatorPluginManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $pluginManager = new ValidatorPluginManager();
        $pluginManager->setServiceLocator($sl);

        return $pluginManager;
    }
}
