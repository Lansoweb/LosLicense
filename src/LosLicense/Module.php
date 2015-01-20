<?php
/**
 * Module file
 *
 * @author     Leandro Silva <leandro@leandrosilva.info>
 * @category   LosLicense
 * @license    https://github.com/Lansoweb/LosLicense/blob/master/LICENSE BSD-3 License
 * @link       http://github.com/LansoWeb/LosLicense
 */
namespace LosLicense;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

/**
 * Module class
 *
 * @author     Leandro Silva <leandro@leandrosilva.info>
 * @category   LosLicense
 * @license    https://github.com/Lansoweb/LosLicense/blob/master/LICENSE BSD-3 License
 * @link       http://github.com/LansoWeb/LosLicense
 */
class Module implements AutoloaderProviderInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap($e)
    {

        $application    = $e->getTarget();
        $serviceManager = $application->getServiceManager();
        $eventManager   = $application->getEventManager();

        // Attach the unlicensed or licensed validators, depending on the loaded license
        $validators = $serviceManager->get('LosLicense\Validator\Validators');

        foreach ($validators as $validator) {
            $eventManager->attachAggregate($validator);
        }
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__.'/../../autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__.'/../../config/module.config.php';
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            'loslicense create' => 'Creates a new license',
            [ '[<outputFile>]'   , 'file to write the license to', 'Prints the output to screen if not provided' ],
        ];
    }
}
