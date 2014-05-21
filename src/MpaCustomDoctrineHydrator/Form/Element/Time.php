<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Form\Element;

use Zend\Filter\StringTrim;

class Time extends DateTime
{
    /**
     * Accepted options for DateTime:
     * - format: A \DateTime compatible string
     *
     * @param  array|\Traversable $options
     * @return \DateTime
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($this->options['time_format'])) {
            $this->setFormat($this->options['time_format']);
        }

        return $this;
    }

    /**
     * Provide default input rules for this element
     * Attaches default validators for the Date input.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->getName(),
            'required'   => true,
            'filters'    => [
                ['name' => StringTrim::class],
                [
                    'name'    => 'MpaCustomDoctrineHydrator\Filter\TimeToDateTime',
                    'options' => [
                        'time_format' => $this->getFormat(),
                    ]
                ],
            ],
            'validators' => [
                $this->getDateValidator()
            ],
        ];
    }
}
