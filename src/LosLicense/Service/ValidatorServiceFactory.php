<?php
namespace LosLicense\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ValidatorServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $service = new ValidatorService();
        $service->setServiceLocator($sl);

        return $service;
    }
}
