<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Form\Annotation;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\Annotation\AnnotationBuilder as ZendAnnotationBuilder;
use Zend\Form\Factory;
use Zend\Form\FormElementManager;

class AnnotationBuilder extends DoctrineAnnotationBuilder
{
    protected $formElementManager;

    /**
     * @param ObjectManager $objectManager
     * @param FormElementManager $formElementManager
     */
    public function __construct(ObjectManager $objectManager, FormElementManager $formElementManager)
    {
        $this->objectManager      = $objectManager;
        $this->formElementManager = $formElementManager;
        /**
         * We set the FEM as form factory so the ZF2 AnnotationBuilder
         * is aware of custom form elements names
         */
        $this->formFactory = new Factory($this->formElementManager);
    }

    /**
     * {@inheritDoc}
     */
    public function setEventManager(EventManagerInterface $events)
    {
        ZendAnnotationBuilder::setEventManager($events);

        $this->getEventManager()
            ->attach(new ElementAnnotationsListener($this->objectManager, $this->formElementManager));

        return $this;
    }
}
