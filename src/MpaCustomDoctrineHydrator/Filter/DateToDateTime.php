<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Filter;

use DateTime;
use Locale;
use Zend\Filter\AbstractFilter;
use Zend\Filter\FilterInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DateToDateTime extends AbstractFilter implements FilterInterface, ServiceLocatorAwareInterface
{
    protected $sm;

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

    /**
     * Converts a date string to a \DateTime
     * according to the date format given
     * @param $value date received
     * @return \DateTime
     */
    public function filter($value)
    {
        /**
         * We try to create a \DateTime according to the format
         * If the creation fails, we return the string itself
         * so it's treated by Validate\Date
         */
        $cdhConfig  = $this->getServiceLocator()->get('Config');
        $dateConfig = $cdhConfig['mpacustomdoctrinehydrator']['formats'][Locale::getDefault()];

        $date = (is_int($value))
            ? date_create("@$value") // from timestamp
            : DateTime::createFromFormat($dateConfig['date_format'], $value);

        // Invalid dates can show up as warnings (ie. "2007-02-99")
        // and still return a DateTime object
        $errors = DateTime::getLastErrors();

        if ($errors['warning_count'] > 0 || $date === false) {
            return $value;
        } else {
            return $date;
        }
    }
}