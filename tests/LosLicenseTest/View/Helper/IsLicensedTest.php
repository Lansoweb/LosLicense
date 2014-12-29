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
namespace LosLicenseTest\View\Helper;

use LosLicense\View\Helper\IsLicensed;
use LosLicenseTest\ServiceManagerTestCase;
use LosLicense\Service\ValidatorServiceAwareTrait;

class IsLicensedTest extends \PHPUnit_Framework_TestCase
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
        $this->helper = new IsLicensed($this->getValidatorService());
    }

    public function setUpNoLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/../../config/nolicense.config.php'));
    }

    public function setUpInvalidLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/../../config/invalidlicense.config.php'));
    }

    public function setUpOutOfDateLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/../../config/beforelicense.config.php'));
    }

    public function testNoLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/../../config/nolicense.config.php'));
        $res = $this->helper->__invoke();
        $this->assertTrue($res);
    }

    public function testInvalidLicenseFile()
    {
        $this->setUpLicense(realpath(__DIR__.'/../../config/invalidlicense.config.php'));
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');
        $res = $this->helper->__invoke();
    }

    public function testOutOfDateLicense()
    {
        $this->setUpLicense(realpath(__DIR__.'/../../config/beforelicense.config.php'));
        $res = $this->helper->__invoke();
        $this->assertFalse($res);
        $this->assertSame('license-before', $this->getValidatorService()->getError());

        $this->setUpLicense(realpath(__DIR__.'/../../config/expiredlicense.config.php'));
        $res = $this->helper->__invoke();
        $this->assertFalse($res);
        $this->assertSame('license-expired', $this->getValidatorService()->getError());
    }
}
