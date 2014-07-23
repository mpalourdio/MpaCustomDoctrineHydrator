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

use MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy\FormatConversionStrategy;

class FormatConversionStrategyTest extends \PHPUnit_Framework_TestCase
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

    public function testFormatConversionStrategyCanExtractAndFormatDate()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig['date_format']);
        $today    = new \DateTime('2014-05-01');

        $this->assertEquals('01/05/2014', $strategy->extract($today));
    }

    public function testFormatConversionStrategyCanExtractAndFormatDateAndTime()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig['datetime_format']);
        $today    = new \DateTime('2014-05-01 05:11:24');

        $this->assertEquals('01/05/2014 05:11:24', $strategy->extract($today));
    }

    public function testFormatConversionStrategyCanExtractAndFormatTime()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig['time_format']);
        $today    = new \DateTime('05:11:24');

        $this->assertEquals('05:11:24', $strategy->extract($today));
    }

    public function testFormatConversionReturnsANullValueIfNullPassedToConstructor()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig['date_format']);
        $today    = null;

        $this->assertNull($strategy->extract($today));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFormatConversionStrategyThrowsExceptionAtExtraction()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig['date_format']);
        $today    = 'chewbacca';
        $strategy->extract($today);
    }

    public function testCanHydrate()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig['date_format']);

        $this->assertEquals('test', $strategy->hydrate('test'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testStrategyThrowsExceptionIfStringNotGiven()
    {
        $strategy = new FormatConversionStrategy($this->dateConfig);

        $this->assertEquals('test', $strategy->hydrate('test'));
    }
}
