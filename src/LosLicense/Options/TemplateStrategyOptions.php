<?php
namespace LosLicense\Options;

use Zend\Stdlib\AbstractOptions;

class TemplateStrategyOptions extends AbstractOptions
{
    protected $template = 'error/403';

    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }
}
