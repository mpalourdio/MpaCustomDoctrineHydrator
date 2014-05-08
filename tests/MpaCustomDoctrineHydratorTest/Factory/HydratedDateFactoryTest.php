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
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            HydratedDate::class,
            $formElementManager->get('MpaCustomDoctrineHydrator\Form\Element\HydratedDate')
        );
    }

    public function testZendFormElementDateIsOverriddenByAlias()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            HydratedDate::class,
            $formElementManager->get('Zend\Form\Element\Date')
        );
    }

    public function testElementNamesOverrideZfOnes()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(HydratedDate::class, $formElementManager->get('Date'));
        $this->assertInstanceOf(HydratedDate::class, $formElementManager->get('Zend\Form\Element\Date'));
        $this->assertInstanceOf(HydratedDate::class, $formElementManager->get(Date::class));
    }

    public function testHasAPlaceholderAsAttribute()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element            = $formElementManager->get('Date');

        $this->assertEquals('jj.mm.aaaa', $element->getAttribute('placeholder'));
    }

    public function testFactorySetsAFormatForDateTime()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element            = $formElementManager->get('Date');

        $this->assertEquals('d.m.Y', $element->getFormat());
    }
}
