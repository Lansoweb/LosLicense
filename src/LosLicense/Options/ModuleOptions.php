<?php
namespace LosLicense\Options;

use Zend\Stdlib\AbstractOptions;
use LosLicense\Exception\InvalidArgumentException;
use LosLicense\License\License;

class ModuleOptions extends AbstractOptions
{

    protected $unlicensedValidators = [];

    protected $licensedValidators = [];

    protected $unlicensedMode = 'blacklist';

    protected $templateStrategy;

    protected $redirectStrategy;

    protected $features;

    protected $signLicense = false;

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

    public function getFeatures()
    {
        return $this->features;
    }

    public function setFeatures(array $features)
    {
        $this->features = $features;

        return $this;
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

    public function getLicense()
    {
        if (null == $this->license) {
            $this->license = new License();
        }

        return $this->license;
    }

    public function setLicense(array $license)
    {
        $this->license = new License($license);
    }
}
