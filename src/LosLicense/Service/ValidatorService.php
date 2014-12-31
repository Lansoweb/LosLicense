<?php
namespace LosLicense\Service;

use Zend\ServiceManager\ServiceLocatorAwareTrait;
use LosLicense\License\License;

class ValidatorService
{
    use ServiceLocatorAwareTrait;

    const LICENSE_INVALID = 'license-invalid';

    const LICENSE_EXPIRED = 'license-expired';

    const LICENSE_BEFORE = 'license-before';

    const LICENSE_TEMPERED = 'license-tempered';

    const MISSING_LICENSE = 'missing-license';

    const MISSING_FEATURE = 'missing-feature';

    protected $error;

    public function isLicensed()
    {
        $this->error = false;

        /* @var $license \LosLicense\License\License */
        $license = $this->getServiceLocator()->get('loslicense.license');

        if (!$license) {
            $this->errors = self::LICENSE_INVALID;

            return false;
        }

        $now = new \DateTime('now');
        if ($license->getValidFrom() && $license->getValidFrom() > $now) {
            $this->error = self::LICENSE_BEFORE;

            return false;
        }

        if ($license->getValidUntil() && $license->getValidUntil() < $now) {
            $this->error = self::LICENSE_EXPIRED;

            return false;
        }

        $options = $this->getServiceLocator()->get('loslicense.options');
        if ($options->getSignLicense() && $license->getSignature() != $this->signLicense($license)) {
            $this->error = self::LICENSE_TEMPERED;

            return false;
        }

        return true;
    }

    public static function signLicense(License $license)
    {
        $str = $license->toArray();
        $salt = $license->getSinagureSalt();
        unset($str['signature']);
        unset($str['attributes']);
        $hash = md5(json_encode($str) . $salt);

        return $hash;
    }

    public function hasFeature($feature)
    {
        $license = $this->getServiceLocator()->get('loslicense.license');

        return $license->hasFeature($feature);
    }

    public function checkLicensesAndFeatures($licenses, $features)
    {
        /* @var $license \LosLicense\License\License */
        $license = $this->getServiceLocator()->get('loslicense.license');

        if (count($licenses) > 0 && !in_array($license->getType(), $licenses)) {
            $this->error = self::MISSING_LICENSE;

            return false;
        }

        if (count($features) > 0 && !$license->hasFeature($features)) {
            $this->error = self::MISSING_FEATURE;

            return false;
        }

        return true;
    }

    public function getError()
    {
        return $this->error;
    }
}
