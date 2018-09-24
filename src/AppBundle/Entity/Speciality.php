<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Speciality
 *
 * @ORM\Table(name="speciality")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialityRepository")
 */
class Speciality
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeSpeciality") 
     *      
     */ 
    private $speciality_type;

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
     * Set description
     *
     * @param string $description
     *
     * @return Speciality
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

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Speciality
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set specialityType
     *
     * @param \AppBundle\Entity\TypeSpeciality $specialityType
     *
     * @return Speciality
     */
    public function setSpecialityType(\AppBundle\Entity\TypeSpeciality $specialityType = null)
    {
        $this->speciality_type = $specialityType;

        return $this;
    }

    /**
     * Get specialityType
     *
     * @return \AppBundle\Entity\TypeSpeciality
     */
    public function getSpecialityType()
    {
        return $this->speciality_type;
    }
}
