<?php
namespace LosLicense\View\Strategy;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LosLicense\Options\RedirectStrategyOptions;

class RedirectStrategyFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $config = $sl->get('loslicense.options');

        if (! $config) {
            return new RedirectStrategy(new RedirectStrategyOptions());
        }

        return new RedirectStrategy($config->getRedirectStrategy());
    }
}
