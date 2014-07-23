<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Factory;

use MpaCustomDoctrineHydrator\Form\Element\Time;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use Zend\Form\Element\Time as ZendTime;

class TimeElementFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testWeCanGrabTheElementByItsFactory()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            Time::class,
            $formElementManager->get('MpaCustomDoctrineHydrator\Form\Element\Time')
        );
    }

    public function testZendFormElementTimeIsOverriddenByAlias()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            Time::class,
            $formElementManager->get('Zend\Form\Element\Time')
        );
    }

    public function testElementNamesOverrideZfOnes()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(Time::class, $formElementManager->get('Time'));
        $this->assertInstanceOf(Time::class, $formElementManager->get('Zend\Form\Element\Time'));
        $this->assertInstanceOf(Time::class, $formElementManager->get(ZendTime::class));
    }

    public function testHasAPlaceholderAsAttribute()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element            = $formElementManager->get('Time');

        $this->assertEquals('hh:mm:ss', $element->getAttribute('placeholder'));
    }

    public function testFactorySetsAFormatForTime()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element            = $formElementManager->get('Time');

        $this->assertEquals('H:i:s', $element->getFormat());
    }
}
