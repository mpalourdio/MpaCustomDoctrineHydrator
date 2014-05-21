<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Factory;

use Locale;
use MpaCustomDoctrineHydrator\Form\Element\Date;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DateElementFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Date
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $serviceLocator FormElementManager */
        $parentLocator = $serviceLocator->getServiceLocator();
        $config        = $parentLocator->get('Config')['mpacustomdoctrinehydrator']['formats'][Locale::getDefault()];

        $formElement = new Date();
        $formElement->setFormat($config['date_format']);
        $formElement->setAttribute('placeholder', $config['date_placeholder']);

        return $formElement;
    }
}
