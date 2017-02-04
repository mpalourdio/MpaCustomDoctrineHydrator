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

use MpaCustomDoctrineHydrator\Form\Element\DateTime;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;
use Zend\Filter\StringTrim;
use Zend\Validator\Date as ZendDateValidator;

class DateTimeTest extends TestCase
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
        $element = new DateTime();
        $element->setAttribute('placeholder', 'ddmmyyyyhhmmss');

        $this->assertInternalType('array', $element->getAttributes());
    }

    public function testElementHasInputSpecification()
    {
        $element = new DateTime();
        $element->setName('datetimeelement');

        $this->assertInternalType('array', $element->getInputSpecification());
    }

    public function testElementHasItsOwnFilters()
    {
        $element = new DateTime();
        $element->setName('datetimeelement');
        $inputSpec = $element->getInputSpecification();

        $this->assertArrayHasKey('filters', $inputSpec, 'testElementHasItsOwnFilters#1');
        $this->assertEquals(
            StringTrim::class,
            $inputSpec['filters'][0]['name'],
            'testElementHasItsOwnFilters#2'
        );
        $this->assertEquals(
            'MpaCustomDoctrineHydrator\Filter\DateTimeToDateTime',
            $inputSpec['filters'][1]['name'],
            'testElementHasItsOwnFilters#3'
        );
    }

    public function testElementHasItsParentValidators()
    {
        $element = new DateTime();
        $element->setName('datetimeelement');
        $inputSpec = $element->getInputSpecification();

        $this->assertArrayHasKey('validators', $inputSpec, 'testElementHasItsParentValidators#1');
        $this->assertInstanceOf(
            ZendDateValidator::class,
            $inputSpec['validators'][0],
            'testElementHasItsParentValidators#2'
        );
    }

    public function testCanSetOptionsForFormat()
    {
        $format  = 'd.m.Y H:i:s';
        $element = new DateTime();
        $element->setName('datetimeelement');
        $element->setOptions(['datetime_format' => $format]);

        $this->assertEquals($format, $element->getOption('datetime_format'));
    }
}
