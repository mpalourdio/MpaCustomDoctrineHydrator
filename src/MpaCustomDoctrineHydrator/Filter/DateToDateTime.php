<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Filter;

use DateTime;
use Zend\Filter\AbstractFilter;
use Zend\Filter\FilterInterface;

class DateToDateTime extends AbstractFilter implements FilterInterface
{
    protected $format = 'Y.m.d';

    /**
     * @param  array|null $options
     * @return self
     */
    public function __construct($options = null)
    {
        if (null !== $options && self::isOptions($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * @param  string $format
     * @return self
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Allow the format key to bey format and date_format
     * For consistency with the ZF2 Date Element
     *
     * @param  array $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->format = isset($options['date_format']) ? $options['date_format'] : $options['format'];

        return $this;
    }

    /**
     * Converts a date string to a \DateTime
     * according to the date format given
     *
     * @param  string $value
     * @return \DateTime|string
     */
    public function filter($value)
    {
        /**
         * We try to create a \DateTime according to the format
         * If the creation fails, we return the string itself
         * so it's treated by Validate\Date
         */

        $date = (is_int($value))
            ? date_create("@$value") // from timestamp
            : DateTime::createFromFormat($this->format, $value);

        // Invalid dates can show up as warnings (ie. "2007-02-99")
        // and still return a DateTime object
        $errors = DateTime::getLastErrors();

        if ($errors['warning_count'] > 0 || $date === false) {
            return $value;
        }

        return $date;
    }
}
