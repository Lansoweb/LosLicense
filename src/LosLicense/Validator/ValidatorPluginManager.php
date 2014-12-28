<?php
namespace LosLicense\Validator;

use Zend\ServiceManager\AbstractPluginManager;
use LosLicense\Exception\RuntimeException;

class ValidatorPluginManager extends AbstractPluginManager
{
    protected $factories = [
        'LosLicense\Validator\ControllerValidator' => 'LosLicense\Validator\ControllerValidatorFactory',
        'LosLicense\Validator\RouteValidator'      => 'LosLicense\Validator\RouteValidatorFactory',
    ];

    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractValidator) {
            return; // we're okay
        }

        throw new RuntimeException(sprintf(
            'Validators must extend from "LosLicense\Validator\AbstractValidator", but "%s" was given',
            is_object($plugin) ? get_class($plugin) : gettype($plugin)
        ));
    }

    protected function canonicalizeName($name)
    {
        return $name;
    }
}
