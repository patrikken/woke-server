<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technician
 *
 * @ORM\Table(name="technician")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TechnicianRepository")
 */
class Technician {

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
     * @ORM\Column(name="businessCard", type="string", length=255)
     */
    private $businessCard;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Devis",mappedBy="technician" , cascade={"remove","persist"}) 
     *      
     */
    private $devis;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Person", cascade={"remove","persist"},
     * inversedBy="technician") 
     */
    private $person;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set businessCard
     *
     * @param string $businessCard
     *
     * @return Technician
     */
    public function setBusinessCard($businessCard) {
        $this->businessCard = $businessCard;

        return $this;
    }

    /**
     * Get businessCard
     *
     * @return string
     */
    public function getBusinessCard() {
        return $this->businessCard;
    }

    /**
     * Add devi
     *
     * @param \AppBundle\Entity\Devis $devi
     *
     * @return Technician
     */
    public function addDevi(\AppBundle\Entity\Devis $devi) {
        $this->devis[] = $devi;

        return $this;
    }

    /**
     * Remove devi
     *
     * @param \AppBundle\Entity\Devis $devi
     */
    public function removeDevi(\AppBundle\Entity\Devis $devi) {
        $this->devis->removeElement($devi);
    }

    /**
     * Get devis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevis() {
        return $this->devis;
    }

    function __construct() {
        $this->devis = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return Technician
     */
    public function setPerson(\AppBundle\Entity\Person $person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AppBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}
