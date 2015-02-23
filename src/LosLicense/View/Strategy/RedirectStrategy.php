<?php
namespace LosLicense\View\Strategy;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use LosLicense\Options\RedirectStrategyOptions;

class RedirectStrategy extends AbstractStrategy
{

    protected $options;

    public function __construct(RedirectStrategyOptions $options)
    {
        $this->options = $options;
    }

    public function onError(MvcEvent $event)
    {
        // Do nothing if no error or if response is not HTTP response
        if (! $this->validateEvent($event)) {
            return;
        }

        $router = $event->getRouter();

        $redirectRoute = $this->options->getRedirectTo();

        $uri = $router->assemble([], [
            'name' => $redirectRoute,
        ]);

        $response = $event->getResponse() ?: new HttpResponse();

        $response->getHeaders()->addHeaderLine('Location', $uri);
        $response->setStatusCode(302);

        $event->setResponse($response);
        $event->setResult($response);
    }
}
