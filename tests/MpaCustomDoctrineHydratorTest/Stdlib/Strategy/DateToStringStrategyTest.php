<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Stdlib\Strategy;

use MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy\DateToStringStrategy;

class DateToStringStrategyTest extends \PHPUnit_Framework_TestCase
{
    protected $dateConfig;

    public function setup()
    {
        $this->dateConfig = [
            'date_format'          => 'd/m/Y',
            'time_format'          => 'H:i:s',
            'datetime_format'      => 'd/m/Y H:i:s',
            'date_placeholder'     => 'jj/mm/aaaa',
            'time_placeholder'     => 'hh:mm:ss',
            'datetime_placeholder' => 'jj/mm/aaaa hh:mm:ss',
        ];
    }

    public function testDateToStringStrategyCanExtractAndFormat()
    {
        $strategy = new DateToStringStrategy($this->dateConfig);
        $today    = new \DateTime('2014-05-01');

        $this->assertEquals('01/05/2014', $strategy->extract($today));
    }

    public function testDateToStringStrategyReturnsANullValueIfNullPassedToConstructor()
    {
        $strategy = new DateToStringStrategy($this->dateConfig);
        $today    = null;

        $this->assertNull($strategy->extract($today));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDateToStringStrategyThrowsException()
    {
        $strategy = new DateToStringStrategy($this->dateConfig);
        $today    = 'chewbacca';
        $strategy->extract($today);
    }
}
