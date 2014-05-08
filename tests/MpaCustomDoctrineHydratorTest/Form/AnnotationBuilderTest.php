<?php

namespace MpaCustomDoctrineHydratorTest\Form;

use MpaCustomDoctrineHydrator\Form\AnnotationBuilder;
use MpaCustomDoctrineHydratorTest\Assets\Entity\Birthday;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use Zend\Form\Factory;
use Zend\Form\Form;

class AnnotationBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $formElementManager;
    protected $entityManager;

    public function setUp()
    {
        \Locale::setDefault('fr-FR');
        $serviceManager = ServiceManagerFactory::getServiceManager();

        $this->entityManager      = $serviceManager->get('doctrine.entitymanager.orm_default');
        $this->formElementManager = $serviceManager->get('FormElementManager');
        $this->builder            = new AnnotationBuilder(
            $this->entityManager,
            $this->formElementManager
        );
    }

    public function testEntityIsBuilt()
    {
        $entity = new Birthday();
        $spec   = $this->builder->getFormSpecification($entity);

        $this->assertCount(6, ($spec['elements']));
    }

    public function testAnnotationBuilderHasFormFactoryInjected()
    {
        $this->assertInstanceOf(Factory::class, $this->builder->getFormFactory());
    }

    public function testAnnotationBuilderCanCreateForm()
    {
        $this->assertInstanceOf(Form::class, $this->builder->createForm(Birthday::class));
    }
}
