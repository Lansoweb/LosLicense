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
        if ($this->validatorService === null) {
            $this->validatorService = new ValidatorService();
        }

        return $this->validatorService;
    }
}
