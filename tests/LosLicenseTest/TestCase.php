<?php
/**
 * Tests for IsLicensed View Helper
 *
 * @author     Leandro Silva <leandro@leandrosilva.info>
 * @category   LosLicense
 * @subpackage Tests
 * @license    http://opensource.org/licenses/MIT   MIT License
 * @link       http://github.com/LansoWeb/LosLicense
 */
namespace LosLicenseTest;

use LosLicenseTest\ServiceManagerTestCase;
use LosLicense\Service\ValidatorServiceAwareTrait;

class TestCase extends \PHPUnit_Framework_TestCase
{
    use ValidatorServiceAwareTrait;

    protected $helper;
    protected $serviceManager;

    public function setUpLicense($globPath)
    {
        $serviceManagerUtil   = new ServiceManagerTestCase();
        $config = $serviceManagerUtil->getConfiguration();
        $config['module_listener_options']['config_glob_paths'] = [$globPath];

        $this->serviceManager = $serviceManagerUtil->getServiceManager($config);

        $this->setValidatorService($this->serviceManager->get('loslicense.validator'));
    }

    public function setUpNoLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/config/nolicense.config.php'));
    }

    public function setUpInvalidLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/config/invalidlicense.config.php'));
    }

    public function setUpBeforeLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/config/beforelicense.config.php'));
    }

    public function setUpExpiredLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/config/expiredlicense.config.php'));
    }

    public function setUpTemperedLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/config/temperedlicense.config.php'));
    }

    public function setUpValidLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/config/validlicense.config.php'));
    }
    
}
