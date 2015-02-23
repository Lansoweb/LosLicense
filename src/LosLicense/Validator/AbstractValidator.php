<?php
namespace LosLicense\Validator;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use LosLicense\Service\ValidatorServiceAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use LosLicense\Exception\InvalidLicenseException;

abstract class AbstractValidator implements ListenerAggregateInterface
{
    use ListenerAggregateTrait, ValidatorServiceAwareTrait, ServiceLocatorAwareTrait;

    const EVENT_PRIORITY = - 5;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [
            $this,
            'onRoute',
        ], static::EVENT_PRIORITY);
    }

    public function onRoute(MvcEvent $event)
    {
        $pass = true;

        if ($this->getValidatorService()->isLicensed()) {
            $pass = $this->checkLicensed($event);
        } elseif (!$this->checkUnlicensed($event)) {
            $pass = false;
        }

        if ($pass) {
            return;
        }

        $event->setError($this->getValidatorService()->getError());
        $event->setParam('exception', new InvalidLicenseException(
            'You are not authorized to access this resource',
            403
        ));

        $event->stopPropagation(true);

        $application = $event->getApplication();
        $eventManager = $application->getEventManager();

        $eventManager->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }

    abstract public function checkLicensed(MvcEvent $event);
    abstract public function checkUnlicensed(MvcEvent $event);
}
