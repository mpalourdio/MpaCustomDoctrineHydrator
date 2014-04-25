<?php

namespace MpaCustomDoctrineHydratorTest\Form\Element;

use MpaCustomDoctrineHydrator\Form\Element\HydratedDate;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;

class HydratedDateTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
        $this->serviceManager->setAllowOverride(true);
    }

    public function testWeCanGrabAttributesFromElement()
    {
        $element            = new HydratedDate();
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element->setServiceLocator($formElementManager);

        $this->assertInternalType('array', $element->getAttributes());
    }

    public function testElementHasInputSpecification()
    {
        $element            = new HydratedDate();
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element->setServiceLocator($formElementManager);
        $element->setName('hydrated');

        $this->assertInternalType('array', $element->getInputSpecification());
    }

    public function testElementHasItsOwnFilters()
    {
        $element            = new HydratedDate();
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element->setServiceLocator($formElementManager);
        $element->setName('hydrated');
        $inputSpec = $element->getInputSpecification();

        $this->assertArrayHasKey('filters', $inputSpec, 'testElementHasItsOwnFilters_1()');
        $this->assertEquals('Zend\Filter\StringTrim', $inputSpec['filters'][0]['name'], 'testElementHasItsOwnFilters_2()');
        $this->assertEquals('DateToDateTime', $inputSpec['filters'][1]['name'], 'testElementHasItsOwnFilters_3()');
    }

    public function testElementHasItsParentValidators()
    {
        $element            = new HydratedDate();
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element->setServiceLocator($formElementManager);
        $element->setName('hydrated');
        $inputSpec = $element->getInputSpecification();

        $this->assertArrayHasKey('validators', $inputSpec, 'testElementHasItsParentValidators_1()');
        $this->assertInstanceOf('Zend\Validator\Date', $inputSpec['validators'][0], 'testElementHasItsParentValidators_2()');
        $this->assertInstanceOf('Zend\Validator\DateStep', $inputSpec['validators'][1], 'testElementHasItsParentValidators_3()');
    }
}
