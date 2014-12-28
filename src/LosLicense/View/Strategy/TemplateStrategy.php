<?php
namespace LosLicense\View\Strategy;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use LosLicense\Exception\UnlicensedException;
use LosLicense\Options\TemplateStrategyOptions;

class TemplateStrategy extends AbstractListenerAggregate
{

    protected $options;

    public function __construct(TemplateStrategyOptions $options)
    {
        $this->options = $options;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [
            $this,
            'onError'
        ]);
    }

    public function onError(MvcEvent $event)
    {
        if (! ($event->getParam('exception') instanceof UnlicensedException) || ($event->getResult() instanceof HttpResponse) || ! ($event->getResponse() instanceof HttpResponse)) {
            return;
        }

        $model = new ViewModel();
        $model->setTemplate($this->options->getTemplate());
        $model->setVariable('error', $event->getError());

        $response = $event->getResponse() ?  : new HttpResponse();
        $response->setStatusCode(403);

        $event->setResponse($response);
        $event->setResult($model);
    }
}
