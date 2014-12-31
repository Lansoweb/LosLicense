<?php
namespace LosLicense\License;

use Zend\Stdlib\AbstractOptions;
use LosLicense\Exception\InvalidArgumentException;

class License extends AbstractOptions
{

    const LICENSE_NONE = 'loslicense-none';

    const LICENSE_TRIAL = 'loslicense-trial';

    const LICENSE_STANDARD = 'loslicense-standard';

    const LICENSE_PERSONAL = 'loslicense-personal';

    protected $type = self::LICENSE_NONE;

    protected $valid_from;

    protected $valid_until;

    protected $customer;

    protected $features;

    protected $attributes;

    protected $signature;

    protected $sinagure_salt = 'SaltToBeUsed';

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getValidFrom()
    {
        return $this->valid_from;
    }

    public function setValidFrom($valid_from)
    {
        try {
            $this->valid_from = new \DateTime($valid_from);
        } catch (\Exception $ex) {
            throw new InvalidArgumentException(sprintf('Invalid datetime string for valid_from: %s', $valid_from), $ex->getCode());
        }
        if ($this->valid_until != null) {
            if ($this->valid_until < $this->valid_from) {
                throw new InvalidArgumentException('valid_until must be after than valid_from');
            }
        }

        return $this;
    }

    public function getValidUntil()
    {
        return $this->valid_until;
    }

    public function setValidUntil($valid_until)
    {
        try {
            $this->valid_until = new \DateTime($valid_until);
        } catch (\Exception $ex) {
            throw new InvalidArgumentException(sprintf('Invalid datetime string for valid_until: %s', $valid_until), $ex->getCode());
        }

        if ($this->valid_from != null) {
            if ($this->valid_from > $this->valid_until) {
                throw new InvalidArgumentException('valid_from must be before than valid_until');
            }
        }

        return $this;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function setFeatures(array $features)
    {
        $list = [];
        foreach ($features as $feature) {
            if (!is_array($feature)) {
                $list[$feature] = null;
            } else {
                list($key, $value) = each($feature);
                $list[$key] = $value;
            }
        }
        $this->features = $list;

        return $this;
    }

    public function hasFeature($features)
    {
        if (!is_array($features)) {
            $features = (array) $features;
        }
        foreach ($features as $feature) {
            if (!in_array($feature, array_keys($this->features))) return false;
        }

        return true;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    public function getSinagureSalt()
    {
        return $this->sinagure_salt;
    }

    public function setSinagureSalt($sinagure_salt)
    {
        $this->sinagure_salt = $sinagure_salt;
        return $this;
    }

}
