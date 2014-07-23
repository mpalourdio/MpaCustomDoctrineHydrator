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
use Zend\Form\Element\Date as ZendDate;
use Zend\InputFilter\InputProviderInterface;

class Date extends ZendDate implements InputProviderInterface
{
    /**
     * Override the type="date" because we can't
     * set a placeholder on html5 date input
     */
    protected $attributes = ['type' => 'text'];

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

        if (isset($this->options['date_format'])) {
            $this->setFormat($this->options['date_format']);
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
                    'name'    => 'MpaCustomDoctrineHydrator\Filter\DateToDateTime',
                    'options' => [
                        'date_format' => $this->getFormat(),
                    ]
                ],
            ],
            'validators' => [
                $this->getDateValidator()
            ],
        ];
    }
}
