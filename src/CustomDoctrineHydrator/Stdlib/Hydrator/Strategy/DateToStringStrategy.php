<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace CustomDoctrineHydrator\Stdlib\Hydrator\Strategy;

use DateTime;
use IntlDateFormatter;
use Locale;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateToStringStrategy implements StrategyInterface
{
    public function extract($value)
    {
        /** @var $value DateTime */
        if (!is_null($value)) {
            if (!($value instanceof DateTime)) {
                throw new \InvalidArgumentException(sprintf(
                        'Field "%s" is not a valid DateTime object',
                        $value)
                );
            }
            $fmt = new IntlDateFormatter(
                Locale::getDefault(),
                IntlDateFormatter::SHORT,
                IntlDateFormatter::NONE,
                $value->getTimezone()->getName(),
                IntlDateFormatter::GREGORIAN
            );

            //we want years to always be 4 chars when pattern has only 2 y or 2 Y
            //substr_count is case sensitive
            if (substr_count(strtolower($fmt->getPattern()), "y") === 2) {
                $fmt->setPattern(str_ireplace('y', 'yy', $fmt->getPattern()));
            }

            //we want days to always be 2 chars when pattern has only 1 d
            if (substr_count($fmt->getPattern(), "d") === 1) {
                $fmt->setPattern(str_ireplace('d', 'dd', $fmt->getPattern()));
            }

            return $fmt->format($value);
        } else {
            return $value;
        }
    }

    public function hydrate($value)
    {
        return $value;
    }
}