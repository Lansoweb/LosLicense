<?php
namespace LosLicense\Validator;

class RouteValidatorFactory extends AbstractValidatorFactory
{
    public function createValidator()
    {
        return new RouteValidator($this->options);
    }
}
