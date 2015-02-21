<?php
namespace LosLicense\Validator;

class ControllerValidatorFactory extends AbstractValidatorFactory
{
    public function createValidator()
    {
        return new ControllerValidator($this->options);
    }
}
