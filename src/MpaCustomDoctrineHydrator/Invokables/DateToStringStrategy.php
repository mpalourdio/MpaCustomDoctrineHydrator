<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Invokables;

use DateTime;
use Locale;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateToStringStrategy implements StrategyInterface, ServiceLocatorAwareInterface
{
    protected $sm;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sm = $serviceLocator;
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

    public function extract($value)
    {
        /** @var $value DateTime */
        if (!is_null($value)) {
            if (!($value instanceof DateTime)) {
                throw new \InvalidArgumentException(sprintf('Field "%s" is not a valid DateTime object', $value));
            }

            $cdhConfig  = $this->getServiceLocator()->get('Config');
            $dateConfig = $cdhConfig['mpacustomdoctrinehydrator']['formats'][Locale::getDefault()];

            return $value->format($dateConfig['date_format']);
        } else {
            return $value;
        }
    }

    public function hydrate($value)
    {
        return $value;
    }
}
