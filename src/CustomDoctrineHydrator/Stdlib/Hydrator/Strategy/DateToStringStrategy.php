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
        if (!is_null($value) && $value instanceof DateTime)
        {
            $fmt = new IntlDateFormatter(
                Locale::getDefault(),
                IntlDateFormatter::SHORT,
                IntlDateFormatter::NONE,
                $value->getTimezone(),
                IntlDateFormatter::GREGORIAN
            );

            return $fmt->format($value);
        } else {
            return null;
        }
    }

    public function hydrate($value)
    {
        return $value;
    }
}