<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MpaCustomDoctrineHydratorTest\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Birthday
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="MpaCustomDoctrineHydratorTest\Assets\Entity\CustomGenerator")
     * @ORM\Column(type="integer")
     */
    protected $identifier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     */
    protected $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $meeting;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time", nullable=false)
     */
    protected $time;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=23)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $age;

    /**
     * @var int
     *
     * @ORM\Column(type="bool", nullable=true)
     */
    protected $canDrinkMojito;

    /**
     * @var int
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $weight;

    /**
     * @param  int $age
     * @return self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param  int $canDrinkMojito
     * @return self
     */
    public function setCanDrinkMojito($canDrinkMojito)
    {
        $this->canDrinkMojito = $canDrinkMojito;

        return $this;
    }

    /**
     * @return int
     */
    public function getCanDrinkMojito()
    {
        return $this->canDrinkMojito;
    }

    /**
     * @param  \DateTime $date
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param  mixed $identifier
     * @return self
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  \DateTime $time
     * @return self
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param  int $weight
     * @return self
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return \DateTime
     */
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * @param \DateTime $meeting
     * @return self
     */
    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;

        return $this;
    }
}
