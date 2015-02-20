<?php
namespace LosLicense\Validator;

use Zend\Mvc\MvcEvent;

class ControllerValidator extends AbstractValidator
{

    const EVENT_PRIORITY = - 10;

    protected $controllers = [];

    public function __construct($controllers)
    {
        $this->setControllers($controllers);
    }

    public function getControllers()
    {
        return $this->controllers;
    }

    public function setControllers($controllers)
    {
        $this->controllers = [];

        foreach ($controllers as $tok) {
            $controller = strtolower($tok['controller']);
            $actions = isset($tok['actions']) ? (array) $tok['actions'] : [];
            $licenses = isset($tok['licenses']) ? (array) $tok['licenses'] : [];
            $features = isset($tok['features']) ? (array) $tok['features'] : [];

            $this->controllers[$controller] = [
                'actions' => [],
                'licenses' => [],
                'features' => []
            ];

            if (! empty($actions)) {
                $this->controllers[$controller]['actions'] = array_map('strtolower', $actions);
            }
            if (! empty($licenses)) {
                $this->controllers[$controller]['licenses'] = $licenses;
            }
            if (! empty($features)) {
                $this->controllers[$controller]['features'] = array_map('strtolower', $features);
            }
        }

        return $this;
    }

    /**
     * Checks if the current controller/action pair should be blocked or not when licensed (valid) and based on features and/or license type.
     *
     * First it will check if the controller is in the list. If it is not, it will pass.
     * Then it will check if the controller AND action are found (including empty actions, meaning the whole controller). If they are not, it will pass.
     * Then it will check if the loaded license type is in the required type list. It if it, it will pass.
     * Finally, it will check if ALL loaded license features are in the required features. If one is missing, it will NOT pass.
     *
     * @param  MvcEvent $event
     * @return boolean  false means 'you shall not pass', true means ok
     */
    public function checkLicensed(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $controller = strtolower($routeMatch->getParam('controller'));
        $action = strtolower($routeMatch->getParam('action'));

        if (! isset($this->controllers[$controller])) {
            return true;
        }

        $canCheck = false;
        if (empty($this->controllers[$controller]['actions'])) {
            $canCheck = true;
        } elseif (in_array($action, $this->controllers[$controller]['actions'])) {
            $canCheck = true;
        }

        if (!$canCheck) {
            return true;
        }

        $service = $this->getServiceLocator()->get('loslicense.validator');

        $licenses = isset($this->controllers[$controller]['licenses']) ? $this->controllers[$controller]['licenses'] : [];
        $features = isset($this->controllers[$controller]['features']) ? $this->controllers[$controller]['features'] : [];

        return $service->checkLicensesAndFeatures($licenses, $features);
    }

    /**
     * Checks if the current controller/action pair should be blocked or not when unlicensed (invalid, out of date or tempered).
     *
     * First it will check if the controller is in the list. If it is NOT and the mode is 'whitelist', it will be blocked, otherwhise, it will pass.
     * Then it will check if the controller/action is and empty array, meaning the whole controller. If it is and the mode is 'blacklist', it will be blocked, otherwhise, it will pass.
     * Then it will check if the controller AND action were defined. If they are and the mode is 'blacklist', it will be blocked, otherwhise, it will pass.
     * Finally, any non-specified controller/action pair will depends on the mode. If it is 'whitelist', it will be blocked, otherwhise, it will pass.
     *
     * @param  MvcEvent $event
     * @return boolean  false means 'you shall not pass', true means ok
     */
    public function checkUnlicensed(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $matchedRouteName = $event->getRouteMatch()->getMatchedRouteName();
        $controller = strtolower($routeMatch->getParam('controller'));
        $action = strtolower($routeMatch->getParam('action'));

        /**
         * LosLicense routes are always accepted
         */
        if (strpos($matchedRouteName, 'loslicense') === 0) {
            return true;
        }

        $options = $this->getServiceLocator()->get('loslicense.options');

        if (! isset($this->controllers[$controller])) {
            return $options->getUnlicensedMode() === 'blacklist';
        } elseif (empty($this->controllers[$controller]['actions'])) {
            return $options->getUnlicensedMode() === 'whitelist';
        } elseif (in_array($action, $this->controllers[$controller]['actions'])) {
            return $options->getUnlicensedMode() === 'whitelist';
        }

        return $options->getUnlicensedMode() === 'blacklist';
    }
}
