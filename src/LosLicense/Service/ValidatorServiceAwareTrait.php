<?php
namespace LosLicense\Service;

trait ValidatorServiceAwareTrait
{
    protected $validatorService;

    public function setValidatorService(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    public function getValidatorService()
    {
        return $this->validatorService;
    }
}
