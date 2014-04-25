<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

return [
    'mpacustomdoctrinehydrator' => [
        'formats' => [
            'fr-FR' => [
                'date_format'          => 'd/m/Y',
                'time_format'          => 'H:i:s',
                'datetime_format'      => 'd/m/Y H:i:s',
                'date_placeholder'     => 'jj/mm/aaaa',
                'time_placeholder'     => 'hh:mm:ss',
                'datetime_placeholder' => 'jj/mm/aaaa hh:mm:ss',
            ],
            'fr-CH' => [
                'date_format'          => 'd.m.Y',
                'time_format'          => 'H:i:s',
                'datetime_format'      => 'd.m.Y H:i:s',
                'date_placeholder'     => 'jj.mm.aaaa',
                'time_placeholder'     => 'hh:mm:ss',
                'datetime_placeholder' => 'jj.mm.aaaa hh:mm:ss',
            ],
        ]
    ],
    'doctrine' => [
        'driver' => [
            'MpaCustomDoctrineHydratorTest\Assets\Entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/MpaCustomDoctrineHydratorTest/Assets/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'MpaCustomDoctrineHydratorTest\Assets\Entity' => 'MpaCustomDoctrineHydratorTest\Assets\Entity',
                ],
            ],
        ],
        'connection' => [
            'orm_default' => [
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',
                'driverClass'   => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => [
                    'memory' => true,
                ],
            ],
        ],
    ],
];
