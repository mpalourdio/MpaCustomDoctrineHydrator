<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Factory;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy\DateToStringStrategy;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomHydratorFactory implements FactoryInterface
{
    /** @var EntityManager $em */
    protected $em;
    /** @var ServiceLocatorInterface $sm */
    protected $sm;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \MpaCustomDoctrineHydrator\Factory\CustomHydratorFactory
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $this->sm = $serviceLocator;

        return $this;
    }

    /**
     * @param String $entity
     * @return DoctrineHydrator
     */
    public function setEntity($entity)
    {
        $hydrator = new DoctrineHydrator($this->em, $entity);

        $columns = $this->em->getClassMetadata($entity)->getColumnNames();
        foreach ($columns as $column) {
            $type = $this->em->getClassMetadata($entity)->getTypeOfColumn($column);
            if ('date' === $type) {
                $strategy = $this->sm->get('datetostringstrategy');
                $hydrator->addStrategy($column, $strategy);
            } elseif ('datetime' === $type) {
                /*$strategy = $this->sm->get('datetimetostringstrategy');
                $hydrator->addStrategy($column, $strategy);*/
            }
        }

        return $hydrator;
    }
}