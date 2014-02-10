<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Form\Element;

use Locale;
use Zend\Form\Element\Date;
use Zend\InputFilter\InputProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HydratedDate extends Date implements InputProviderInterface, ServiceLocatorAwareInterface
{
    protected $sm;
    protected $attributes;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sm = $serviceLocator->getServiceLocator();
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->sm;
    }

    public function getAttributes()
    {
        $cdhConfig  = $this->sm->get('Config');
        $dateConfig = $cdhConfig['mpacustomdoctrinehydrator']['formats'][Locale::getDefault()];

        $this->attributes                = parent::getAttributes();
        $this->attributes['placeholder'] = $dateConfig['date_placeholder'];

        return $this->attributes;
    }

    /**
     * Provide default input rules for this element
     *
     * Attaches default validators for the datetime input.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->getName(),
            'required'   => true,
            'filters'    => [
                ['name' => 'Zend\Filter\StringTrim'],
                ['name' => 'DateToDateTime'],
            ],
            'validators' => $this->getValidators(),
        ];
    }
}
