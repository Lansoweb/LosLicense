<?php
namespace LosLicense\License;

class TrialLicense extends License
{
    public function getType()
    {
        return LicenseInterface::LICENSE_TRIAL;
    }
}
