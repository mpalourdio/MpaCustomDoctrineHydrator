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

use MpaCustomDoctrineHydrator\Filter\TimeToDateTime;
use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;

class TimeToDateTimeTest extends TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testStringWellFormattedTimeReturnsADateTimeObject()
    {
        $serviceConfig = $this->serviceManager
            ->get('Config')['mpacustomdoctrinehydrator']['formats'][\Locale::getDefault()];
        $filter        = new TimeToDateTime($serviceConfig);

        $this->assertEquals('DateTime', get_class($filter('08:05:48')));
    }

    public function testStringWronglyFormattedTimeReturnsTheSameValue()
    {
        $serviceConfig = $this->serviceManager
            ->get('Config')['mpacustomdoctrinehydrator']['formats'][\Locale::getDefault()];
        $filter        = new TimeToDateTime($serviceConfig);

        $this->assertEquals('100.102.20102', $filter('100.102.20102'));
    }

    public function testCanManuallySetformat()
    {
        $filter = new TimeToDateTime();
        $filter->setFormat('H:i:s');

        $this->assertEquals('DateTime', get_class($filter('07:05:48')));
    }

    public function testFormatAndTimeFormatAreValidConfigKeysForFilterOptions()
    {
        $filter = new TimeToDateTime();

        $filter->setOptions(['time_format' => 'time_format']);
        $this->assertEquals($filter->getFormat(), 'time_format');

        $filter->setOptions(['format' => 'format']);
        $this->assertEquals($filter->getFormat(), 'format');
    }
}
