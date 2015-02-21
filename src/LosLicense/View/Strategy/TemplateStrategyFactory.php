<?php
namespace LosLicense\View\Strategy;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LosLicense\Options\TemplateStrategyOptions;

class TemplateStrategyFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $config = $sl->get('loslicense.options');

        if (! $config) {
            return new TemplateStrategy(new TemplateStrategyOptions());
        }

        return new TemplateStrategy($config->getTemplateStrategy());
    }
}
