<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use MpaCustomDoctrineHydrator\Filter\DateToDateTimeFactory;
use MpaCustomDoctrineHydrator\Form\Element\HydratedDateFactory;
use MpaCustomDoctrineHydrator\Services\CustomHydratorFactory;

return [
    'service_manager' => [
        'factories' => [
            'customdoctrinehydrator' => CustomHydratorFactory::class,
        ],
    ],
    'filters'         => [
        'factories' => [
            'DateToDateTime' => DateToDateTimeFactory::class,
        ],
    ],
    'form_elements'   => [
        'factories' => [
            'Date' => HydratedDateFactory::class,
        ],
        'aliases'   => [
            'Zend\Form\Element\Date' => 'Date',
        ]
    ],
];
