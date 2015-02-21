<?php
namespace LosLicense\License;

use Zend\Stdlib\AbstractOptions;
use LosLicense\Exception\InvalidArgumentException;

abstract class License extends AbstractOptions implements LicenseInterface
{
    use FeaturesTrait;

    protected $__strictMode__ = false;

    protected $valid_from;

    protected $valid_until;

    protected $customer;

    protected $attributes;

    protected $signature;

    public function getValidFrom()
    {
        return $this->valid_from;
    }

    private function validateDate($date)
    {
        try {
            $dt = new \DateTime($date);
            return $dt;
        } catch (\Exception $ex) {
            throw new InvalidArgumentException(sprintf('Invalid datetime string for: %s', $date), $ex->getCode());
        }
    }

    private function validateDateRange()
    {
        if ($this->valid_from === null || $this->valid_until === null) {
            return true;
        }

        if ($this->valid_until < $this->valid_from) {
            throw new InvalidArgumentException('valid_until must be greater than valid_from');
        }
    }

    public function setValidFrom($valid_from)
    {
        $this->valid_from = $this->validateDate($valid_from);
        $this->validateDateRange();

        return $this;
    }

    public function getValidUntil()
    {
        return $this->valid_until;
    }

    public function setValidUntil($valid_until)
    {
        $this->valid_until = $this->validateDate($valid_until);
        $this->validateDateRange();

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

    abstract public function getType();
}
