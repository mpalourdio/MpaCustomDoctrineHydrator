<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Form\Annotation;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineORMModule\Form\Annotation\ElementAnnotationsListener as DoctrineElementAnnotationsListener;
use Zend\EventManager\EventInterface;
use Zend\Form\FormElementManager;
use Zend\Validator\Callback;

class ElementAnnotationsListener extends DoctrineElementAnnotationsListener
{
    /**
     * @param ObjectManager      $objectManager
     * @param FormElementManager $formElementManager
     */
    public function __construct(ObjectManager $objectManager, FormElementManager $formElementManager)
    {
        $this->objectManager      = $objectManager;
        $this->formElementManager = $formElementManager;
    }

    /**
     * @param EventInterface $event
     * @internal
     */
    public function handleFilterField(EventInterface $event)
    {
        $metadata = $event->getParam('metadata');
        if (!$metadata || !$metadata->hasField($event->getParam('name'))) {
            return;
        }

        $this->prepareEvent($event);

        $inputSpec = $event->getParam('inputSpec');

        switch ($metadata->getTypeOfField($event->getParam('name'))) {
            case 'bool':
            case 'boolean':
                $inputSpec['filters'][] = ['name' => 'Boolean'];
                break;
            case 'bigint':
            case 'integer':
            case 'smallint':
                /**
                 * empty string return null, '0' is a valid number
                 * and we don't want an empty field to return 0
                 */
                $inputSpec['filters'][] = ['name' => 'StringTrim'];
                $inputSpec['filters'][] = [
                    'name'    => 'Null',
                    'options' => [
                        'type' => 'string'
                    ],
                ];
                break;
            case 'date':
                /**
                 * grab the filters of the HydratedDate Element
                 */
                $filters = $this->formElementManager->get('Date')->getInputSpecification()['filters'];
                foreach ($filters as $filter) {
                    $inputSpec['filters'][] = $filter;
                }
                break;
            case 'datetime':
            case 'datetimetz':
            case 'time':
                $inputSpec['filters'][] = ['name' => 'StringTrim'];
                break;
            case 'string':
            case 'text':
                /**
                 * empty string return null, but we allow '0'
                 */
                $inputSpec['filters'][] = ['name' => 'StringTrim'];
                $inputSpec['filters'][] = [
                    'name'    => 'Null',
                    'options' => [
                        'type' => 'string'
                    ],
                ];
        }
    }

    /**
     * @param EventInterface $event
     * @internal
     */
    public function handleValidatorField(EventInterface $event)
    {
        $mapping  = $this->getFieldMapping($event);
        $metadata = $event->getParam('metadata');
        if (!$mapping) {
            return;
        }

        $this->prepareEvent($event);

        $inputSpec = $event->getParam('inputSpec');

        switch ($metadata->getTypeOfField($event->getParam('name'))) {
            case 'bool':
            case 'boolean':
                $inputSpec['validators'][] = [
                    'name'    => 'InArray',
                    'options' => ['haystack' => ['0', '1']]
                ];
                break;
            case 'float':
                $inputSpec['validators'][] = ['name' => 'Float'];
                break;
            case 'bigint':
            case 'integer':
            case 'smallint':
                $inputSpec['validators'][] = ['name' => 'Digits'];
                break;
            /**
             * here we provide a callback, because StringLength
             * validator shocks with null values
             */
            case 'string':
                if (isset($mapping['length'])) {
                    $inputSpec['validators'][] = [
                        'name'    => 'Callback',
                        'options' => [
                            'callback'        => [$this, 'stringLengthValidatorCallback'],
                            'callbackOptions' => [
                                [
                                    'length' => $mapping['length']
                                ],
                            ],
                            'messages'        => [
                                Callback::INVALID_VALUE => 'Maximum allowed text size exceeded',
                            ],
                        ],
                    ];
                }
                break;
            /**
             * grab the validators of the HydratedDate Element
             */
            case 'date':
                $validators = $this->formElementManager->get('Date')->getInputSpecification()['validators'];
                foreach ($validators as $validator) {
                    $inputSpec['validators'][] = $validator;
                }
                break;
        }
    }

    /**
     * @param string $value
     * @param array  $context
     * @param array  $options
     * @return bool
     */
    public function stringLengthValidatorCallback($value, $context, $options)
    {
        if (null !== $value && strlen($value) > $options['length']) {
            return false;
        }

        return true;
    }
}
