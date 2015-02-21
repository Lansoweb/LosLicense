<?php
namespace LosLicense\License;

trait FeaturesTrait
{

    protected $features;

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
}
