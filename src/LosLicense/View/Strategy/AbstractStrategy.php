<?php
namespace LosLicense\View\Strategy;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use LosLicense\Exception\UnlicensedException;

abstract class AbstractStrategy extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [
            $this,
            'onError',
        ]);
    }

    protected function validateEvent(MvcEvent $event)
    {
        // Do nothing if no error or if response is not HTTP response
        if (! ($event->getParam('exception') instanceof UnlicensedException) || ($event->getResult() instanceof HttpResponse) || ! ($event->getResponse() instanceof HttpResponse)) {
            return false;
        }

        return true;
    }
}
