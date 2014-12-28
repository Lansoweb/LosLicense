<?php
namespace LosLicense\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HasFeatureFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        return new HasFeature($sl->getServiceLocator()->get('loslicense.validator'));
    }
}
