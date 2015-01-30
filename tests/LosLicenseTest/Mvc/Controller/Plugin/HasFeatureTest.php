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

use LosLicense\Mvc\Controller\Plugin\HasFeature;
use LosLicenseTest\TestCase;

class HasFeatureTest extends TestCase
{
    protected $helper;

    public function setUpLicense($globPath)
    {
        parent::setUpLicense($globPath);
        $this->helper = new HasFeature($this->getValidatorService());
    }

    public function testNoLicense()
    {
        $this->setUpNoLicense();
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');
        $res = $this->helper->__invoke('numTest');
    }

    public function testInvalidLicenseFile()
    {
        $this->setUpInvalidLicense();
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');
        $res = $this->helper->__invoke('numTest');
    }

    public function testOutOfDateLicense()
    {
        $this->setUpBeforeLicense();
        $res = $this->helper->__invoke('numTest');
        $this->assertFalse($res);

        $this->setUpExpiredLicense();
        $res = $this->helper->__invoke('numTest');
        $this->assertFalse($res);
    }

    public function testTemperedLicense()
    {
        $this->setUpTemperedLicense();
        $res = $this->helper->__invoke('numTest');
        $this->assertFalse($res);
    }

    public function testHasFeature()
    {
        $this->setUpValidLicense();
        $res = $this->helper->__invoke('numTest');
        $this->assertTrue($res);
    }

    public function testNotHasFeature()
    {
        $this->setUpValidLicense();
        $res = $this->helper->__invoke('numTest2');
        $this->assertFalse($res);
    }

}
