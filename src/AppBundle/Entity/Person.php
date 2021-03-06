<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 * @ExclusionPolicy("all")
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Expose
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="cni", type="string", length=255)
     * @Expose
     */
    private $cni;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     * @Expose
     */
    private $phone;
    
    
    /**
     *@ORM\OneToOne(targetEntity="AppBundle\Entity\User" , cascade={"persist"},
     * inversedBy="person") 
     *@ORM\JoinColumn(nullable=false)      
     */
    private $user;
     
    
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Technician", cascade={"remove","persist"},
     * mappedBy="person")
     * @Expose 
     */
    private $technician; 
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Incident",mappedBy="person" , cascade={"remove","persist"}) 
     *      
     */
    private $incidents;
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set cni
     *
     * @param string $cni
     *
     * @return Person
     */
    public function setCni($cni)
    {
        $this->cni = $cni;

        return $this;
    }

    /**
     * Get cni
     *
     * @return string
     */
    public function getCni()
    {
        return $this->cni;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
     
    function __construct() {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

 

    /**
     * Add incident
     *
     * @param \AppBundle\Entity\Incident $incident
     *
     * @return Person
     */
    public function addIncident(\AppBundle\Entity\Incident $incident)
    {
        $this->incidents[] = $incident;

        return $this;
    }

    /**
     * Remove incident
     *
     * @param \AppBundle\Entity\Incident $incident
     */
    public function removeIncident(\AppBundle\Entity\Incident $incident)
    {
        $this->incidents->removeElement($incident);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents()
    {
        return $this->incidents;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Person
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set technician
     *
     * @param \AppBundle\Entity\Technician $technician
     *
     * @return Person
     */
    public function setTechnician(\AppBundle\Entity\Technician $technician)
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
