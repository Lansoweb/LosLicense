<?php
namespace LosLicenseTest\Options;

use LosLicense\Options\ModuleOptions;
use LosLicense\Options\TemplateStrategyOptions;
use LosLicense\Options\RedirectStrategyOptions;
use LosLicense\License\License;
use LosLicenseTest\TestCase;
use LosLicense\License\TrialLicense;

/**
 * ModuleOptions test case.
 */
class ModuleOptionsTest extends TestCase
{

    /**
     *
     * @var ModuleOptions
     */
    private $ModuleOptions;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->ModuleOptions = new ModuleOptions();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ModuleOptions = null;

        parent::tearDown();
    }

    /**
     * Tests ModuleOptions->getUnlicensedValidators()
     */
    public function testSetGetUnlicensedValidators()
    {
        $this->ModuleOptions->getUnlicensedValidators(/* parameters */);
    }

    /**
     * Tests ModuleOptions->setUnlicensedValidators()
     */
    public function testGetSetUnlicensedValidators()
    {
        $validators = [
            'LosLicense\Validator\ControllerValidator' => [
                [
                    'controller' => 'application\controller\index',
                    'actions' => [
                        'foo',
                    ],
                ],
            ],
        ];
        $this->ModuleOptions->setUnlicensedValidators($validators);
        $this->assertSame($validators, $this->ModuleOptions->getUnlicensedValidators());
    }

    /**
     * Tests ModuleOptions->setLicensedValidators()
     */
    public function testSetLicensedValidators()
    {
        $validators = [
            'LosLicense\Validator\ControllerValidator' => [
                [
                    'controller' => 'application\controller\index',
                    'actions' => [
                        'foo',
                    ],
                    'features' => [
                        'test',
                    ],
                ],
            ],
        ];
        $this->ModuleOptions->setLicensedValidators($validators);
        $this->assertSame($validators, $this->ModuleOptions->getLicensedValidators());
    }

    /**
     * Tests ModuleOptions->setUnlicensedMode()
     */
    public function testSetGetUnlicensedMode()
    {
        $this->ModuleOptions->setUnlicensedMode('whitelist');
        $this->assertSame('whitelist', $this->ModuleOptions->getUnlicensedMode());
    }

    public function testSetInvalidUnlicensedMode()
    {
        $this->setExpectedException('LosLicense\Exception\InvalidArgumentException');
        $this->ModuleOptions->setUnlicensedMode('invalid');
    }

    /**
     * Tests ModuleOptions->setTemplateStrategy()
     */
    public function testSetGetTemplateStrategy()
    {
        $strategy = new TemplateStrategyOptions([
            'template' => 'myerror/403',
        ]);
        $this->ModuleOptions->setTemplateStrategy([
            'template' => 'myerror/403',
        ]);
        $this->assertEquals($strategy, $this->ModuleOptions->getTemplateStrategy());
    }

    /**
     * Tests ModuleOptions->getTemplateStrategy()
     */
    public function testSetInvalidTemplateStrategy()
    {
        $this->setExpectedException('Zend\Stdlib\Exception\BadMethodCallException');
        $this->ModuleOptions->setTemplateStrategy([
            'invalid',
        ]);
    }

    /**
     * Tests ModuleOptions->setRedirectStrategy()
     */
    public function testSetGetRedirectStrategy()
    {
        $strategy = new RedirectStrategyOptions([
            'redirectTo' => 'myerror',
        ]);
        $this->ModuleOptions->setRedirectStrategy([
            'redirectTo' => 'myerror',
        ]);
        $this->assertEquals($strategy, $this->ModuleOptions->getRedirectStrategy());
    }

    /**
     * Tests ModuleOptions->getRedirectStrategy()
     */
    public function testSetInvalidRedirectStrategy()
    {
        $this->setExpectedException('Zend\Stdlib\Exception\BadMethodCallException');
        $this->ModuleOptions->setRedirectStrategy([
            'invalid',
        ]);
    }

    /**
     * Tests ModuleOptions->getFeatures()
     */
    public function testSetGetFeatures()
    {
        $rawFeatures = [
            'numTest' => 20,
            'testFeature',
        ];
        $features = [
            'numTest' => 20,
            'testFeature' => null,
        ];
        $this->ModuleOptions->setFeatures($rawFeatures);
        $this->assertSame($features, $this->ModuleOptions->getFeatures());
    }

    /**
     * Tests ModuleOptions->getSignLicense()
     */
    public function testSetGetSignLicense()
    {
        $this->ModuleOptions->setSignLicense(true);
        $this->assertSame(true, $this->ModuleOptions->getSignLicense());
    }

    /**
     * Tests ModuleOptions->getSignatureSalt()
     */
    public function testSetGetSignatureSalt()
    {
        $this->ModuleOptions->setSignatureSalt('salt');
        $this->assertSame('salt', $this->ModuleOptions->getSignatureSalt());
    }

    /**
     * Tests ModuleOptions->getLicense()
     */
    public function testSetGetLicense()
    {
        $licenseData = [
            'type' => License::LICENSE_TRIAL,
            'valid_from' => '2014-12-25 12:01:02',
            'valid_until' => '2014-12-30',
            'customer' => 'Leandro Silva',
            'features' => [
                'num_teste' => 5,
                'teste',
            ],
            'attributes' => [
                'max_teste' => 20,
            ],
            'signature' => '1f22f0199f9e9646a8dc59c6dd45d9d4',
        ];
        $license = new TrialLicense($licenseData);
        $this->ModuleOptions->setLicense($licenseData);
        $this->assertEquals($license, $this->ModuleOptions->getLicense());
    }

    /**
     * Tests ModuleOptions->setLicense()
     */
    public function testSetInvalidLicense()
    {
        $this->setExpectedException('LosLicense\Exception\InvalidArgumentException');
        $this->ModuleOptions->setLicense([
            'invalid',
        ]);
    }
}
