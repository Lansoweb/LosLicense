<?php
namespace LosLicense\Options;

use Zend\Stdlib\AbstractOptions;

class RedirectStrategyOptions extends AbstractOptions
{
    protected $redirectTo = 'loslicense-invalid';

    public function setRedirectTo($redirectTo)
    {
        $this->redirectTo = (string) $redirectTo;
    }

    public function getRedirectTo()
    {
        return $this->redirectTo;
    }
}
