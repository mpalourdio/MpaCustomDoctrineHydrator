<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Services;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy\FormatConversionStrategy;

class EntityAttacher
{
    protected $objectManager;
    protected $dateConfig;
    protected $doctrineObject;

    /**
     * @param ObjectManager  $objectManager
     * @param array          $dateConfig
     * @param DoctrineObject $doctrineObject
     */
    public function __construct(
        ObjectManager $objectManager,
        array $dateConfig,
        DoctrineObject $doctrineObject
    ) {
        $this->objectManager  = $objectManager;
        $this->dateConfig     = $dateConfig;
        $this->doctrineObject = $doctrineObject;
    }

    /**
     * @param  string $entity
     * @return DoctrineObject
     */
    public function setEntity($entity)
    {
        $columns = $this->objectManager->getClassMetadata($entity)->getColumnNames();
        foreach ($columns as $column) {
            $type = $this->objectManager->getClassMetadata($entity)->getTypeOfColumn($column);
            if ('date' === $type) {
                $this->doctrineObject->addStrategy(
                    $column,
                    new FormatConversionStrategy($this->dateConfig['date_format'])
                );
            } elseif ('datetime' === $type) {
                $this->doctrineObject->addStrategy(
                    $column,
                    new FormatConversionStrategy($this->dateConfig['datetime_format'])
                );
            }
        }

        return $this->doctrineObject;
    }
}
