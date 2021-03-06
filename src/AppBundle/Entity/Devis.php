<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devis
 *
 * @ORM\Table(name="devis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DevisRepository")
 */
class Devis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Incident", cascade={"remove"}) 
     *      
     */ 
    private $incident;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * 
     */
    private $description;
    
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Technician", cascade={"remove"}) 
     *      
     */ 
    private $technician;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Devis
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set incident
     *
     * @param \AppBundle\Entity\Incident $incident
     *
     * @return Devis
     */
    public function setIncident(\AppBundle\Entity\Incident $incident = null)
    {
        $this->incident = $incident;

        return $this;
    }

    /**
     * Get incident
     *
     * @return \AppBundle\Entity\Incident
     */
    public function getIncident()
    {
        return $this->incident;
    }

    /**
     * Set technician
     *
     * @param \AppBundle\Entity\Technician $technician
     *
     * @return Devis
     */
    public function setTechnician(\AppBundle\Entity\Technician $technician = null)
    {
        $this->technician = $technician;

        return $this;
    }

    /**
     * Get technician
     *
     * @return \AppBundle\Entity\Technician
     */
    public function getTechnician()
    {
        return $this->technician;
    }
    
    function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Devis
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
