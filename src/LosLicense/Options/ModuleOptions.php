<?php
namespace LosLicense\Options;

use Zend\Stdlib\AbstractOptions;
use LosLicense\Exception\InvalidArgumentException;
use LosLicense\Exception\RuntimeException;
use LosLicense\License\LicenseInterface;
use LosLicense\License\TrialLicense;
use LosLicense\License\PersonalLicense;
use LosLicense\License\StandardLicense;
use LosLicense\License\FeaturesTrait;

class ModuleOptions extends AbstractOptions
{
    use FeaturesTrait;

    protected $unlicensedValidators = [];

    protected $licensedValidators = [];

    protected $unlicensedMode = 'blacklist';

    protected $templateStrategy;

    protected $redirectStrategy;

    protected $signLicense = false;

    protected $signature_salt = 'SaltToBeUsed';

    protected $license;

    public function getUnlicensedValidators()
    {
        return $this->unlicensedValidators;
    }

    public function setUnlicensedValidators(array $unlicensedValidators)
    {
        $this->unlicensedValidators = $unlicensedValidators;

        return $this;
    }

    public function getLicensedValidators()
    {
        return $this->licensedValidators;
    }

    public function setLicensedValidators(array $licensedValidators)
    {
        $this->licensedValidators = $licensedValidators;

        return $this;
    }

    public function setUnlicensedMode($unlicensedMode)
    {
        if ($unlicensedMode != 'whitelist' && $unlicensedMode != 'blacklist') {
            throw new InvalidArgumentException(sprintf('Invalid unlicensed mode set. Must be either "whitelist" or "blacklist", "%s" given', $unlicensedMode));
        }

        $this->unlicensedMode = $unlicensedMode;
    }

    public function getUnlicensedMode()
    {
        return $this->unlicensedMode;
    }

    public function setTemplateStrategy(array $templateStrategy)
    {
        $this->templateStrategy = new TemplateStrategyOptions($templateStrategy);
    }

    public function getTemplateStrategy()
    {
        if (null === $this->templateStrategy) {
            $this->templateStrategy = new TemplateStrategyOptions();
        }

        return $this->templateStrategy;
    }

    public function setRedirectStrategy(array $redirectStrategy)
    {
        $this->redirectStrategy = new RedirectStrategyOptions($redirectStrategy);
    }

    public function getRedirectStrategy()
    {
        if (null === $this->redirectStrategy) {
            $this->redirectStrategy = new RedirectStrategyOptions();
        }

        return $this->redirectStrategy;
    }

    public function getSignLicense()
    {
        return $this->signLicense;
    }

    public function setSignLicense($signLicense)
    {
        $this->signLicense = $signLicense;

        return $this;
    }

    public function getSignatureSalt()
    {
        return $this->signature_salt;
    }

    public function setSignatureSalt($signature_salt)
    {
        $this->signature_salt = $signature_salt;

        return $this;
    }

    public function getLicense()
    {
        if (null === $this->license) {
            throw new RuntimeException("License not set yet.");
        }

        return $this->license;
    }

    public function setLicense(array $license)
    {
        if (! \array_key_exists('type', $license)) {
            throw new InvalidArgumentException("License configuration must have a 'type' key.");
        }
        if ($license['type'] == LicenseInterface::LICENSE_TRIAL) {
            $this->license = new TrialLicense($license);
        } elseif ($license['type'] == LicenseInterface::LICENSE_PERSONAL) {
            $this->license = new PersonalLicense($license);
        } elseif ($license['type'] == LicenseInterface::LICENSE_STANDARD) {
            $this->license = new StandardLicense($license);
        } else {
            throw new InvalidArgumentException(sprintf("Invalid '%s' license type.", $license['type']));
        }
    }
}
