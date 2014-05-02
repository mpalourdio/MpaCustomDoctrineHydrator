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

class DateToDatetimeFactoryTest extends \PHPUnit_Framework_TestCase
{

    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testWeCanGrabTheFilterByItsFactoryShortName()
    {
        $filterManager = $this->serviceManager->get('FilterManager');
        $this->assertInstanceOf(DateToDateTime::class, $filterManager->get('DateToDateTime'));
    }
}
