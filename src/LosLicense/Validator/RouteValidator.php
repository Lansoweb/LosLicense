<?php
namespace LosLicense\Validator;

use Zend\Mvc\MvcEvent;

class RouteValidator extends AbstractValidator
{

    const EVENT_PRIORITY = - 10;

    protected $routes = [];

    public function __construct($routes)
    {
        $this->setRoutes($routes);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function setRoutes($routes)
    {
        $this->routes = [];

        foreach ($routes as $key => $value) {
            if (is_int($key)) {
                $routeRegex = $value;
                $roles = [];
            } else {
                $routeRegex = $key;
                $roles = (array) $value;
            }

            $this->routes[$routeRegex] = $roles;
        }
    }

    public function checkLicensed(MvcEvent $event)
    {
        $matchedRouteName = $event->getRouteMatch()->getMatchedRouteName();

        foreach (array_keys($this->routes) as $route) {
            if (fnmatch($route, $matchedRouteName, FNM_CASEFOLD)) {
                $service = $this->getServiceLocator()->get('loslicense.validator');

                $licenses = isset($this->routes[$route]['licenses']) ? $this->routes[$route]['licenses'] : [];
                $features = isset($this->routes[$route]['features']) ? $this->routes[$route]['features'] : [];

                return $service->checkLicensesAndFeatures($licenses, $features);
            }
        }

        return true;
    }

    /**
     * Checks if the current controller/action pair should be blocked or not
     *
     * First, will check if the controller is in the options. If it is NOT and the mode is 'whitelist', it will be blocked, otherwhise, it will pass.
     * Then, will check if the controller is and empty array. If it is and the mode is 'blacklist', it will be blocked, otherwhise, it will pass.
     * Then, will check if the controller AND action were defined. If they are and the mode is 'blacklist', it will be blocked, otherwhise, it will pass.
     * Finally, any non-specified controller/action pair will depends on the mode. If it is 'whitelist', it will be blocked, otherwhise, it will pass.
     *
     * @param  MvcEvent $event
     * @return boolean  false means 'you shall not pass', true means ok
     */
    public function checkUnlicensed(MvcEvent $event)
    {
        $matchedRouteName = $event->getRouteMatch()->getMatchedRouteName();

        /**
         * LosLicense routes are always accepted
         */
        if (strpos($matchedRouteName, 'loslicense') === 0) {
            return true;
        }

        $options = $this->getServiceLocator()->get('loslicense.options');

        if (empty($this->routes)) {
            return $options->getUnlicensedMode() === 'blacklist';
        }

        foreach (array_keys($this->routes) as $route) {
            if (fnmatch($route, $matchedRouteName, FNM_CASEFOLD)) {
                return $options->getUnlicensedMode() === 'whitelist';
            }
        }

        return $options->getUnlicensedMode() === 'blacklist';
    }
}
