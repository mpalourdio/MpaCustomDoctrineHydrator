<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Form\Element;

use MpaCustomDoctrineHydrator\Form\Element\HydratedDate;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use Zend\Filter\StringTrim;
use Zend\Validator\Date;

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
        $element = new HydratedDate();
        $element->setAttribute('placeholder', 'ddmmyyyy');

        $this->assertInternalType('array', $element->getAttributes());
    }

    public function testElementHasInputSpecification()
    {
        $element = new HydratedDate();
        $element->setName('hydrated');

        $this->assertInternalType('array', $element->getInputSpecification());
    }

    public function testElementHasItsOwnFilters()
    {
        $element = new HydratedDate();
        $element->setName('hydrated');
        $inputSpec = $element->getInputSpecification();

        $this->assertArrayHasKey('filters', $inputSpec, 'testElementHasItsOwnFilters#1');
        $this->assertEquals(
            StringTrim::class,
            $inputSpec['filters'][0]['name'],
            'testElementHasItsOwnFilters#2'
        );
        $this->assertEquals(
            'MpaCustomDoctrineHydrator\Filter\DateToDateTimeFilter',
            $inputSpec['filters'][1]['name'],
            'testElementHasItsOwnFilters#3'
        );
    }

    public function testElementHasItsParentValidators()
    {
        $element = new HydratedDate();
        $element->setName('hydrated');
        $inputSpec = $element->getInputSpecification();

        $this->assertArrayHasKey('validators', $inputSpec, 'testElementHasItsParentValidators#1');
        $this->assertInstanceOf(
            Date::class,
            $inputSpec['validators'][0],
            'testElementHasItsParentValidators#2'
        );
    }

    public function testCanSetOptionsForFormat()
    {
        $format  = 'd.m.Y';
        $element = new HydratedDate();
        $element->setName('hydrated');
        $element->setOptions(['date_format' => $format]);

        $this->assertEquals($format, $element->getOption('date_format'));
    }

    public function testExtendsDateButIsAnInputText()
    {
        $element = new HydratedDate();

        $this->assertEquals('text', $element->getAttribute('type'));
    }
}
