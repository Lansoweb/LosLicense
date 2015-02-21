<?php
namespace LosLicense\Validator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;

abstract class AbstractValidatorFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    protected $options = [];

    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        $validator = $this->createValidator();
        $validator->setValidatorService($sl->getServiceLocator()->get('LosLicense\Service\ValidatorService'));
        $validator->setServiceLocator($sl->getServiceLocator());

        return $validator;
    }

    abstract public function createValidator();
}
