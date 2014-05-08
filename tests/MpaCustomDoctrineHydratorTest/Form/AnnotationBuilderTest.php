<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
