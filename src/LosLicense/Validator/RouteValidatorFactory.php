<?php
namespace LosLicense\Validator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;

class RouteValidatorFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    protected $options = [];

    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        $validator = new RouteValidator($this->options);
        $validator->setValidatorService($sl->getServiceLocator()->get('LosLicense\Service\ValidatorService'));
        $validator->setServiceLocator($sl->getServiceLocator());

        return $validator;
    }
}
