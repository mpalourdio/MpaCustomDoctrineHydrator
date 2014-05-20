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

use Doctrine\ORM\EntityManagerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy\FormatConversionStrategy;

class CustomHydrator
{
    protected $entityManager;
    protected $dateConfig;

    /**
     * @param EntityManagerInterface $entityManager
     * @param array                  $dateConfig
     */
    public function __construct(EntityManagerInterface $entityManager, array $dateConfig)
    {
        $this->entityManager = $entityManager;
        $this->dateConfig    = $dateConfig;
    }

    /**
     * @param  string $entity
     * @return DoctrineHydrator
     */
    public function setEntity($entity)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);

        $columns = $this->entityManager->getClassMetadata($entity)->getColumnNames();
        foreach ($columns as $column) {
            $type = $this->entityManager->getClassMetadata($entity)->getTypeOfColumn($column);
            if ('date' === $type) {
                $hydrator->addStrategy($column, new FormatConversionStrategy($this->dateConfig['date_format']));
            } elseif ('datetime' === $type) {
                $hydrator->addStrategy($column, new FormatConversionStrategy($this->dateConfig['datetime_format']));
            }
        }

        return $hydrator;
    }
}
