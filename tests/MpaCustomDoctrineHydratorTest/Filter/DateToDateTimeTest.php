<?php
namespace MpaCustomDoctrineHydratorTest\Filter;

use MpaCustomDoctrineHydrator\Filter\DateToDateTime;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;

class DateToDateTimeTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
        $this->serviceManager->setAllowOverride(true);
    }

    public function testStringWellFormattedDateReturnsADateTimeObeject()
    {
        $filterManager = $this->serviceManager->get('FilterManager');
        $filter        = new DateToDateTime();
        $filter->setServiceLocator($filterManager);

        $this->assertEquals('DateTime', get_class($filter('10.12.2012')));
    }

    public function testStringWronglyFormattedDateReturnsTheSameValue()
    {
        $filterManager = $this->serviceManager->get('FilterManager');
        $filter        = new DateToDateTime();
        $filter->setServiceLocator($filterManager);

        $this->assertEquals('100.102.20102', $filter('100.102.20102'));
    }
}
