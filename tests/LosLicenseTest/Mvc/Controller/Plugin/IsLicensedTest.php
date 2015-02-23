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
namespace LosLicenseTest\Mvc\Controller\Plugin;

use LosLicense\Mvc\Controller\Plugin\IsLicensed;
use LosLicenseTest\TestCase;

class IsLicensedTest extends TestCase
{
    protected $helper;

    public function setUpLicense($globPath)
    {
        parent::setUpLicense($globPath);
        $this->helper = new IsLicensed($this->getValidatorService());
    }

    public function testNoLicense()
    {
        $this->setUpNoLicense();
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');
        $res = $this->helper->__invoke();
    }

    public function testInvalidLicenseFile()
    {
        $this->setUpInvalidLicense();
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');
        $res = $this->helper->__invoke();
    }

    public function testOutOfDateLicense()
    {
        $this->setUpBeforeLicense();
        $res = $this->helper->__invoke();
        $this->assertFalse($res);
        $this->assertSame('license-before', $this->getValidatorService()->getError());

        $this->setUpExpiredLicense();
        $res = $this->helper->__invoke();
        $this->assertFalse($res);
        $this->assertSame('license-expired', $this->getValidatorService()->getError());
    }

    public function testTemperedLicense()
    {
        $this->setUpTemperedLicense();
        $res = $this->helper->__invoke();
        $this->assertFalse($res);
        $this->assertSame('license-tempered', $this->getValidatorService()->getError());
    }

    public function testValidLicense()
    {
        $this->setUpValidLicense();
        $res = $this->helper->__invoke();
        $this->assertTrue($res);
        $this->assertFalse($this->getValidatorService()->getError());
    }
}
