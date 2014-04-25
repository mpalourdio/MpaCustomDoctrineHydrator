<?php

namespace MpaCustomDoctrineHydratorTest\Invokables;

use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;

class CustomHydratorTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testCustomHydratorIsADoctrineObjectInstance()
    {
        $customHydrator = $this->serviceManager
            ->get('customdoctrinehydrator')
            ->setEntity('MpaCustomDoctrineHydratorTest\Assets\Entity\Birthday');

        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $customHydrator);
    }

    public function testCustomHydratorHasDateStrategiesAttached()
    {
        $customHydrator = $this->serviceManager
            ->get('customdoctrinehydrator')
            ->setEntity('MpaCustomDoctrineHydratorTest\Assets\Entity\Birthday');

        $this->assertTrue($customHydrator->hasStrategy('date'));
    }
}
