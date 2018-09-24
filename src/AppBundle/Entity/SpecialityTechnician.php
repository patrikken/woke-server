<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialityTechnician
 *
 * @ORM\Table(name="speciality_technician")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialityTechnicianRepository")
 */
class SpecialityTechnician
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
     * @ORM\Column(name="principal", type="boolean")
     */
    private $principal;

    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Speciality") 
     *      
     */ 
    private $speciality;
    
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Technician")
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
     * Set principal
     *
     * @param boolean $principal
     *
     * @return SpecilityTechnician
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return bool
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set speciality
     *
     * @param \AppBundle\Entity\Speciality $speciality
     *
     * @return SpecialityTechnician
     */
    public function setSpeciality(\AppBundle\Entity\Speciality $speciality = null)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return \AppBundle\Entity\Speciality
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set technician
     *
     * @param \AppBundle\Entity\Technician $technician
     *
     * @return SpecialityTechnician
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
}
