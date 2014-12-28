<?php
namespace LosLicense\View\Helper;

use Zend\View\Helper\AbstractHelper;
use LosLicense\Service\ValidatorService;

class HasFeature extends AbstractHelper
{
    private $validatorService;

    public function __construct(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    public function __invoke($feature)
    {
        return $this->validatorService->hasFeature($feature);
    }
}
