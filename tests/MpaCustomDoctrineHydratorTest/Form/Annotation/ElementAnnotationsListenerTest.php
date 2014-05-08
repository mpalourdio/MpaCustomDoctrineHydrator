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
