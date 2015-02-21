<?php
namespace LosLicense\License;

interface LicenseInterface
{

    const LICENSE_TRIAL = 'loslicense-trial';

    const LICENSE_STANDARD = 'loslicense-standard';

    const LICENSE_PERSONAL = 'loslicense-personal';

    public function getValidFrom();

    public function setValidFrom($valid_from);

    public function getValidUntil();

    public function setValidUntil($valid_until);

    public function getCustomer();

    public function setCustomer($customer);

    public function getFeatures();

    public function setFeatures(array $features);

    public function hasFeature($features);

    public function getFeature($feature);

    public function getAttributes();

    public function setAttributes(array $attributes);

    public function hasAttribute($attributes);

    public function getAttribute($attribute);

    public function getSignature();

    public function setSignature($signature);
}
