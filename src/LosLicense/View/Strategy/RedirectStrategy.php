<?php
namespace LosLicense\View\Strategy;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use LosLicense\Exception\UnlicensedException;
use LosLicense\Options\RedirectStrategyOptions;

class RedirectStrategy extends AbstractListenerAggregate
{
    protected $options;

    public function __construct(RedirectStrategyOptions $options)
    {
        $this->options               = $options;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onError']);
    }

    public function onError(MvcEvent $event)
    {
        // Do nothing if no error or if response is not HTTP response
        if (!($event->getParam('exception') instanceof UnlicensedException)
            || ($event->getResult() instanceof HttpResponse)
            || !($event->getResponse() instanceof HttpResponse)
        ) {
            return;
        }

        $router = $event->getRouter();

        $redirectRoute = $this->options->getRedirectTo();

        $uri = $router->assemble([], ['name' => $redirectRoute]);

        $response = $event->getResponse() ?: new HttpResponse();

        $response->getHeaders()->addHeaderLine('Location', $uri);
        $response->setStatusCode(302);

        $event->setResponse($response);
        $event->setResult($response);
    }
}
