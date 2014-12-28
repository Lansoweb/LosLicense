<?php
namespace LosLicense\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use LosLicense\Service\ValidatorService;

class IsLicensed extends AbstractPlugin
{
    private $validatorService;

    public function __construct(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    public function __invoke()
    {
        return $this->validatorService->isLicensed();
    }
}
