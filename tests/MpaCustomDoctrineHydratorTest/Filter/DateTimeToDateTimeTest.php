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

use MpaCustomDoctrineHydrator\Filter\DateTimeToDateTime;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;

class DateTimeToDateTimeTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testStringWellFormattedDateAndTimeReturnsADateTimeObject()
    {
        $serviceConfig = $this->serviceManager
            ->get('Config')['mpacustomdoctrinehydrator']['formats'][\Locale::getDefault()];
        $filter        = new DateTimeToDateTime($serviceConfig);

        $this->assertEquals('DateTime', get_class($filter('10.12.2012 08:05:48')));
    }

    public function testStringWronglyFormattedDateAndTimeReturnsTheSameValue()
    {
        $serviceConfig = $this->serviceManager
            ->get('Config')['mpacustomdoctrinehydrator']['formats'][\Locale::getDefault()];
        $filter        = new DateTimeToDateTime($serviceConfig);

        $this->assertEquals('100.102.20102', $filter('100.102.20102'));
    }

    public function testCanManuallySetformat()
    {
        $filter        = new DateTimeToDateTime();
        $filter->setFormat('d/m/Y H:i:s');

        $this->assertEquals('DateTime', get_class($filter('10/12/2012 07:05:48')));
    }

    public function testFormatAndDatetimeFormatAreValidConfigKeysForFilterOptions()
    {
        $filter        = new DateTimeToDateTime();

        $filter->setOptions(['datetime_format' => 'datetime_format']);
        $this->assertEquals($filter->getFormat(), 'datetime_format');

        $filter->setOptions(['format' => 'format']);
        $this->assertEquals($filter->getFormat(), 'format');
    }
}
