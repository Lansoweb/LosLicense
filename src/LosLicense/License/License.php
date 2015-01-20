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
        foreach ($features as $feature => $value) {
            if (is_numeric($feature)) {
                $feature = $value;
                $value = null;
            }
            $list[$feature] = $value;
        }
        $this->features = $list;

        return $this;
    }

    public function hasFeature($features)
    {
        if (empty($this->features)) {
            return false;
        }

        if (!is_array($features)) {
            $features = (array) $features;
        }
        foreach ($features as $feature) {
            if (!in_array($feature, array_keys($this->features))) return false;
        }

        return true;
    }

    public function getFeature($feature)
    {
        if (empty($this->features)) {
            return false;
        }

        if (in_array($feature, array_keys($this->features))) return $this->features[$feature];
        return false;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $list = [];
        foreach ($attributes as $attribute => $value) {
            if (is_numeric($attribute)) {
                $attribute = $value;
                $value = null;
            }
            $list[$attribute] = $value;
        }
        $this->attributes = $list;

        return $this;
    }

    public function hasAttribute($attributes)
    {
        if (empty($this->attributes)) {
            return false;
        }

        if (!is_array($attributes)) {
            $attributes = (array) $attributes;
        }
        foreach ($attributes as $attribute) {
            if (!in_array($attribute, array_keys($this->attributes))) return false;
        }

        return true;
    }

    public function getAttribute($attribute)
    {
        if (empty($this->attributes)) {
            return false;
        }

        if (in_array($attribute, array_keys($this->attributes))) return $this->attributes[$attribute];
        return false;
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

}
