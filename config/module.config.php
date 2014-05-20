<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use MpaCustomDoctrineHydrator\Factory\AnnotationBuilderFactory;
use MpaCustomDoctrineHydrator\Factory\DateElementFactory;
use MpaCustomDoctrineHydrator\Factory\DateTimeElementFactory;
use MpaCustomDoctrineHydrator\Factory\DateTimeToDateTimeFilterFactory;
use MpaCustomDoctrineHydrator\Factory\DateToDateTimeFilterFactory;
use MpaCustomDoctrineHydrator\Factory\EntityAttacherFactory;

return [
    'service_manager' => [
        'factories' => [
            'hydrator'          => EntityAttacherFactory::class,
            'annotationbuilder' => AnnotationBuilderFactory::class,
        ],
    ],
    'filters'         => [
        'factories' => [
            'DateToDateTime'     => DateToDateTimeFilterFactory::class,
            'DateTimeToDateTime' => DateTimeToDateTimeFilterFactory::class,
        ],
    ],
    'form_elements'   => [
        'factories' => [
            'Date'     => DateElementFactory::class,
            'DateTime' => DateTimeElementFactory::class,
        ],
        'aliases'   => [
            'Zend\Form\Element\Date'     => 'Date',
            'Zend\Form\Element\DateTime' => 'DateTime',
        ]
    ],
];
