<?php
namespace LosLicense\License;

class PersonalLicense extends License
{
    public function getType()
    {
        return LicenseInterface::LICENSE_PERSONAL;
    }
}
