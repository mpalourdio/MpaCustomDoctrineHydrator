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

class DateTimeToDateTime extends DateToDateTime
{
    protected $format = 'Y.m.d H:i:s';

    /**
     * Allow the format key to be format and datetime_format
     * For consistency with the ZF2 Date Element
     *
     * @param  array $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->format = isset($options['datetime_format']) ? $options['datetime_format'] : $options['format'];

        return $this;
    }
}
