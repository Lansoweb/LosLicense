<?php
namespace LosLicense\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $config = $sl->get('Configuration');

        return new ModuleOptions(isset($config['loslicense']) ? $config['loslicense'] : []);
    }
}
