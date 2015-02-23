<?php
namespace LosLicense\View\Strategy;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use LosLicense\Options\TemplateStrategyOptions;

class TemplateStrategy extends AbstractStrategy
{

    protected $options;

    public function __construct(TemplateStrategyOptions $options)
    {
        $this->options = $options;
    }

    public function onError(MvcEvent $event)
    {
        if (!$this->validateEvent($event)) {
            return;
        }

        $model = new ViewModel();
        $model->setTemplate($this->options->getTemplate());
        $model->setVariable('error', $event->getError());

        $response = $event->getResponse() ?: new HttpResponse();
        $response->setStatusCode(403);

        $event->setResponse($response);
        $event->setResult($model);
    }
}
