<?php
namespace MpaCustomDoctrineHydratorTest\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Birthday
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @param \DateTime $date
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
     * @param int $identifier
     * @return self
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
