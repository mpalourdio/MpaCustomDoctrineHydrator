<?php

namespace MpaCustomDoctrineHydratorTest\Listener;

use MpaCustomDoctrineHydrator\Listener\ElementAnnotationsListener;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;

class ElementAnnotationsListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $formElementManager;
    protected $entityManager;

    public function setUp()
    {
        $serviceManager = ServiceManagerFactory::getServiceManager();

        $this->entityManager      = $serviceManager->get('doctrine.entitymanager.orm_default');
        $this->formElementManager = $serviceManager->get('FormElementManager');
    }

    public function testCallbackReturnsFalse()
    {
        $listener = new ElementAnnotationsListener(
            $this->entityManager,
            $this->formElementManager
        );
        $result   = $listener->stringLengthValidatorCallback('test', null, ['length' => 3]);

        $this->assertFalse($result);
    }

    public function testCallbackReturnsTrue()
    {
        $listener = new ElementAnnotationsListener(
            $this->entityManager,
            $this->formElementManager
        );
        $result   = $listener->stringLengthValidatorCallback('test', null, ['length' => 4]);

        $this->assertTrue($result);
    }
}
