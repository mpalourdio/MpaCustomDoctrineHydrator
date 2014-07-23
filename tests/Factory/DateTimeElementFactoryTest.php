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

use MpaCustomDoctrineHydrator\Form\Element\DateTime;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use Zend\Form\Element\DateTime as ZendDateTime;

class DateTimeElementFactoryTest extends \PHPUnit_Framework_TestCase
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
            DateTime::class,
            $formElementManager->get('MpaCustomDoctrineHydrator\Form\Element\DateTime')
        );
    }

    public function testZendFormElementDateTimeIsOverriddenByAlias()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(
            DateTime::class,
            $formElementManager->get('Zend\Form\Element\DateTime')
        );
    }

    public function testElementNamesOverrideZfOnes()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');

        $this->assertInstanceOf(DateTime::class, $formElementManager->get('DateTime'));
        $this->assertInstanceOf(DateTime::class, $formElementManager->get('Zend\Form\Element\DateTime'));
        $this->assertInstanceOf(DateTime::class, $formElementManager->get(ZendDateTime::class));
    }

    public function testHasAPlaceholderAsAttribute()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element            = $formElementManager->get('DateTime');

        $this->assertEquals('jj.mm.aaaa hh:mm:ss', $element->getAttribute('placeholder'));
    }

    public function testFactorySetsAFormatForDateTime()
    {
        $formElementManager = $this->serviceManager->get('FormElementManager');
        $element            = $formElementManager->get('DateTime');

        $this->assertEquals('d.m.Y H:i:s', $element->getFormat());
    }
}
