<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Form\Annotation;

use MpaCustomDoctrineHydrator\Form\Annotation\ElementAnnotationsListener;
use MpaCustomDoctrineHydratorTest\Assets\Entity\Birthday;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;
use Zend\EventManager\Event;

class ElementAnnotationsListenerTest extends TestCase
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

    public function testCustomGeneratorAreExcluded()
    {
        $event    = new Event();
        $metadata = $this->entityManager->getClassMetadata(Birthday::class);

        $event->setParam('metadata', $metadata);
        $event->setParam('name', 'identifier');

        $listener = new ElementAnnotationsListener(
            $this->entityManager,
            $this->formElementManager
        );

        $this->assertTrue($listener->handleExcludeField($event));
    }

    public function testNoMetadataReturnsNull()
    {
        $event = new Event();

        $event->setParam('metadata', null);

        $listener = new ElementAnnotationsListener(
            $this->entityManager,
            $this->formElementManager
        );

        $this->assertNull($listener->handleFilterField($event));
    }

    public function testMetadataButNoNameReturnsNull()
    {
        $event    = new Event();
        $metadata = $this->entityManager->getClassMetadata(Birthday::class);

        $event->setParam('metadata', $metadata);

        $listener = new ElementAnnotationsListener(
            $this->entityManager,
            $this->formElementManager
        );

        $this->assertNull($listener->handleFilterField($event));
    }

    public function testNoMappingReturnsNull()
    {
        $event    = new Event();
        $listener = new ElementAnnotationsListener(
            $this->entityManager,
            $this->formElementManager
        );

        $this->assertNull($listener->handleValidatorField($event));
    }
}
