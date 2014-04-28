<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Filter;

use MpaCustomDoctrineHydrator\Filter\DateToDateTime;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;

class DateToDateTimeTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testStringWellFormattedDateReturnsADateTimeObeject()
    {
        $filterManager = $this->serviceManager->get('FilterManager');
        $filter        = new DateToDateTime();
        $filter->setServiceLocator($filterManager);

        $this->assertEquals('DateTime', get_class($filter('10.12.2012')));
    }

    public function testStringWronglyFormattedDateReturnsTheSameValue()
    {
        $filterManager = $this->serviceManager->get('FilterManager');
        $filter        = new DateToDateTime();
        $filter->setServiceLocator($filterManager);

        $this->assertEquals('100.102.20102', $filter('100.102.20102'));
    }
}
