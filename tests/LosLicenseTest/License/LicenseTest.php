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
namespace LosLicenseTest\License;

use LosLicense\License\License;
use LosLicenseTest\ServiceManagerTestCase;
use LosLicenseTest\TestCase;

class LicenseTest extends TestCase
{
    protected $license;
    protected $rawFeatures = 
    [
        'feature1',
        ['feature2' => 10]
    ];
    protected $rawAttributes =
    [
        'attribute1',
        ['attribute2' => 10]
    ];
    

    public function setUp()
    {
        $this->license = new License();
    }
    
    public function setUpLicense($globPath)
    {
        parent::setUpLicense($globPath);
    }

    public function testType()
    {
        $this->license->setType(License::LICENSE_STANDARD);
        $this->assertSame(License::LICENSE_STANDARD, $this->license->getType());
    }

    public function testValidFrom()
    {
        $date = '2014-12-30 12:01:02';
        $this->license->setValidFrom($date);
        $this->assertSame($date, $this->license->getValidFrom()->format('Y-m-d H:i:s'));
    }

    public function testInvalidFrom()
    {
        $this->setExpectedException('LosLicense\Exception\InvalidArgumentException');
        $date = 'abc';
        $this->license->setValidFrom($date);
    }

    public function testValidUntil()
    {
        $date = '2014-12-30 12:01:02';
        $this->license->setValidUntil($date);
        $this->assertSame($date, $this->license->getValidUntil()->format('Y-m-d H:i:s'));
    }
    
    public function testInvalidUntil()
    {
        $this->setExpectedException('LosLicense\Exception\InvalidArgumentException');
        $date = 'abc';
        $this->license->setValidUntil($date);
    }

    public function testUntilBeforeFromDates()
    {
        $this->setExpectedException('LosLicense\Exception\InvalidArgumentException');
        $from  = '2014-12-30 12:01:02';
        $until = '2014-12-20 12:01:02';
        $this->license->setValidFrom($from);
        $this->license->setValidUntil($until);
    }

    public function testFromAfterUntilDates()
    {
        $this->setExpectedException('LosLicense\Exception\InvalidArgumentException');
        $from  = '2014-12-30 12:01:02';
        $until = '2014-12-20 12:01:02';
        $this->license->setValidUntil($until);
        $this->license->setValidFrom($from);
    }

    public function testCustomer()
    {
        $customer = 'Leandro Silva';
        $this->license->setCustomer($customer);
        $this->assertSame($customer, $this->license->getCustomer());
    }
    
    public function testFeatures()
    {
        $features = [
            'feature1' => null,
            'feature2' => 10
        ];
        $this->license->setFeatures($this->rawFeatures);
        $this->assertSame($features, $this->license->getFeatures());
    }
    
    public function testHasFeature()
    {
        $this->license->setFeatures($this->rawFeatures);
        $this->assertTrue($this->license->hasFeature('feature1'));
        $this->assertFalse($this->license->hasFeature('feature0'));
    }

    public function testGetFeature()
    {
        $this->license->setFeatures($this->rawFeatures);
        $this->assertSame(10, $this->license->getFeature('feature2'));
    }

    public function testAttributes()
    {
        $attributes = [
            'attribute1' => null,
            'attribute2' => 10
        ];
        $this->license->setAttributes($this->rawAttributes);
        $this->assertSame($attributes, $this->license->getAttributes());
    }
    
    public function testHasAttribute()
    {
        $this->license->setAttributes($this->rawAttributes);
        $this->assertTrue($this->license->hasAttribute('attribute1'));
        $this->assertFalse($this->license->hasAttribute('attribute0'));
    }
    
    public function testGetAttributes()
    {
        $this->license->setAttributes($this->rawAttributes);
        $this->assertSame(10, $this->license->getAttribute('attribute2'));
    }

    public function testSignature()
    {
        $signature = '123';
        $this->license->setSignature($signature);
        $this->assertSame($signature, $this->license->getSignature());
    }
    
}
