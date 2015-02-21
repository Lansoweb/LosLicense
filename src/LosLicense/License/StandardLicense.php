<?php
namespace LosLicense\License;

class StandardLicense extends License
{
    public function getType()
    {
        return LicenseInterface::LICENSE_STANDARD;
    }
}
