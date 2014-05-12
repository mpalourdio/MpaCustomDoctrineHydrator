<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy;

use DateTime;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateToStringStrategy implements StrategyInterface
{
    protected $dateConfig;

    /**
     * @param array $dateConfig
     */
    public function __construct(array $dateConfig)
    {
        $this->dateConfig = $dateConfig;
    }

    /**
     * @param  DateTime|null $value
     * @return string|null
     * @throws \InvalidArgumentException
     */
    public function extract($value)
    {
        /** @var $value DateTime */
        if (null !== $value) {
            if (!($value instanceof DateTime)) {
                throw new \InvalidArgumentException(sprintf('Field "%s" is not a valid DateTime object', $value));
            }

            return $value->format($this->dateConfig['date_format']);
        } else {
            return $value;
        }
    }

    /**
     * @param  string $value
     * @return string
     */
    public function hydrate($value)
    {
        return $value;
    }
}
