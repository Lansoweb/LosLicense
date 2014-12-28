<?php
namespace LosLicense\Mvc\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IsLicensedFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        return new IsLicensed($sl->getServiceLocator()->get('loslicense.validator'));
    }
}
