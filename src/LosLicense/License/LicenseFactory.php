<?php
namespace LosLicense\License;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LicenseFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        /* @var $config \LosLicense\Options\ModuleOptions */
        $config = $sl->get('loslicense.options');

        if (! $config) {
            return false;
        }

        return $config->getLicense();
    }
}
