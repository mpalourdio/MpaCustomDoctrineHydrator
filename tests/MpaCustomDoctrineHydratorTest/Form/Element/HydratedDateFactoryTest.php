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
use Zend\Form\Element\Date;

class HydratedDateFactoryTest extends \PHPUnit_Framework_TestCase
{

    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testWeCanGrabTheElementByItsFactory()
    {
        $filterManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            HydratedDate::class,
            $filterManager->get('MpaCustomDoctrineHydrator\Form\Element\HydratedDate')
        );
    }

    public function testZendFormElementDateIsOverriddenByAlias()
    {
        $filterManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            HydratedDate::class,
            $filterManager->get('Zend\Form\Element\Date')
        );
    }

    public function testElementNamesOverrideZfOnes()
    {
        $filterManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(HydratedDate::class, $filterManager->get('Date'));
        $this->assertInstanceOf(HydratedDate::class, $filterManager->get('Zend\Form\Element\Date'));
        $this->assertInstanceOf(HydratedDate::class, $filterManager->get(Date::class));
    }

    public function testHasAPlaceholderAsAttribute()
    {
        $filterManager = $this->serviceManager->get('FormElementManager');
        $element       = $filterManager->get('Date');

        $this->assertEquals('jj.mm.aaaa', $element->getAttribute('placeholder'));
    }

    public function testFactorySetsAFormatForDateTime()
    {
        $filterManager = $this->serviceManager->get('FormElementManager');
        $element       = $filterManager->get('Date');

        $this->assertEquals('d.m.Y', $element->getFormat());
    }
}
