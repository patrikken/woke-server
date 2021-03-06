<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * User
 *
 * @ORM\Table(name="user") 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User implements \Symfony\Component\Security\Core\User\AdvancedUserInterface, \Serializable {

    const ROLE_PRO="ROLE_PRO";
    const ROLE_PERSON="ROLE_PERSON";

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
     * @ORM\Column(name="login", type="string", length=255, unique=true)
     * @Expose
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Expose
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     * @Expose
     */
    private $role;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean")
     */
    private $enable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked;
    
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Person", cascade={"remove","persist"},
     * mappedBy="user")
     * @Expose 
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
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login) {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return [$this->role];
    }

    public function getSalt() {
        
    }

    public function getUsername() {
        return $this->login;
    }

    public function isAccountNonExpired() {
        return TRUE;
    }

    public function isAccountNonLocked() {
        return $this->locked;
    }

    public function isCredentialsNonExpired() {
        return TRUE;
    }

    public function isEnabled() {
        return $this->enable;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return User
     */
    public function setEnable($enable) {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return boolean
     */
    public function getEnable() {
        return $this->enable;
    }

    function __construct() {
        $this->date = new \DateTime();
        $this->enable = false;
        $this->locked = true;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return User
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    public function serialize() {
        return serialize([
            $this->id,
            $this->login,
            $this->locked,
            $this->enable,
            $this->password,
            $this->role
        ]);
    }

    public function unserialize($serialized) {
        list(
                $this->id,
                $this->login,
                $this->locked,
                $this->enable,
                $this->password,
                $this->role
                ) = unserialize($serialized);
    }


    
 
 

    /**
     * Set person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return User
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


    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }
}
