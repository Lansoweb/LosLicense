<?php
namespace LosLicense\View\Helper;

use Zend\View\Helper\AbstractHelper;
use LosLicense\Service\ValidatorService;

class IsLicensed extends AbstractHelper
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
