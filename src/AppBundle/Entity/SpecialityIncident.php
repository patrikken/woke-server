<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialityIncident
 *
 * @ORM\Table(name="speciality_incident")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialityIncidentRepository")
 */
class SpecialityIncident
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
     * @var bool
     *
     * @ORM\Column(name="obligated", type="boolean")
     */
    private $obligated;

    
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Incident") 
     *      
     */ 
    private $incident;
    
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeSpeciality")
     *      
     */ 
    private $type_speciality;

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
     * Set obligated
     *
     * @param boolean $obligated
     *
     * @return SpecialityIncident
     */
    public function setObligated($obligated)
    {
        $this->obligated = $obligated;

        return $this;
    }

    /**
     * Get obligated
     *
     * @return bool
     */
    public function getObligated()
    {
        return $this->obligated;
    }
 

    /**
     * Set typeSpeciality
     *
     * @param \AppBundle\Entity\TypeSpeciality $typeSpeciality
     *
     * @return SpecialityIncident
     */
    public function setTypeSpeciality(\AppBundle\Entity\TypeSpeciality $typeSpeciality = null)
    {
        $this->type_speciality = $typeSpeciality;

        return $this;
    }

    /**
     * Get typeSpeciality
     *
     * @return \AppBundle\Entity\TypeSpeciality
     */
    public function getTypeSpeciality()
    {
        return $this->type_speciality;
    }

    /**
     * Set incident
     *
     * @param \AppBundle\Entity\Incident $incident
     *
     * @return SpecialityIncident
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
    
    function __construct() {
        $this->obligated = true;
    }

}
