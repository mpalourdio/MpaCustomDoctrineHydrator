<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Invokables;

use MpaCustomDoctrineHydratorTest\Util\ServiceManagerFactory;
use MpaCustomDoctrineHydratorTest\Assets\Entity\Birthday;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class CustomHydratorTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        \Locale::setDefault('fr-CH');
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testCustomHydratorIsADoctrineObjectInstance()
    {
        $customHydrator = $this->serviceManager
            ->get('customdoctrinehydrator')
            ->setEntity(Birthday::class);

        $this->assertInstanceOf(DoctrineObject::class, $customHydrator);
    }

    public function testCustomHydratorHasDateStrategiesAttached()
    {
        $customHydrator = $this->serviceManager
            ->get('customdoctrinehydrator')
            ->setEntity(Birthday::class);

        $this->assertTrue($customHydrator->hasStrategy('date'));
    }
}
