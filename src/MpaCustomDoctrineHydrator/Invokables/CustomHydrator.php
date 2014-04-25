<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydrator\Invokables;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Locale;
use MpaCustomDoctrineHydrator\Stdlib\Hydrator\Strategy\DateToStringStrategy;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomHydrator implements ServiceLocatorAwareInterface
{

    protected $serviceLocator;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }


    public function setEntity($entity)
    {
        $entityManager = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
        $hydrator      = new DoctrineHydrator($entityManager);

        $cdhConfig  = $this->serviceLocator->get('Config');
        $dateConfig = $cdhConfig['mpacustomdoctrinehydrator']['formats'][Locale::getDefault()];

        $columns = $entityManager->getClassMetadata($entity)->getColumnNames();
        foreach ($columns as $column) {
            $type = $entityManager->getClassMetadata($entity)->getTypeOfColumn($column);
            if ('date' === $type) {
                $hydrator->addStrategy($column, new DateToStringStrategy($dateConfig));
            }
        }

        return $hydrator;
    }
}
