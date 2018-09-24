<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Tools;

use AppBundle\Entity\Person;
use AppBundle\Entity\Technician;
 

/**
 * Description of ValidateData
 *
 * @author uni2grow
 */
class ValidateData {
    private $em;
    
    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function isValidePerson(Person $person) {
        $error = [];
        if (empty(trim($person->getName()))) {
            $error['name'] = "Please enter a name.";
        }

        if (empty(trim($person->getFirstName()))) {
            $error['firstName'] = "Please enter a first name.";
        }

        if (empty(trim($person->getCni()))) {
            $error['cni'] = "Please enter a CNI value";
        } elseif (!filter_var($person->getCni(), FILTER_VALIDATE_INT) || strlen($person->getCni()) < 7) {
            $error['cni'] = "The CNI is not valid";
        }

        if (empty(trim($person->getPhone()))) {
            $error['phone'] = "Please enter a phone number.";
        } elseif (strlen($person->getPhone()) < 7) {
            $error['phone'] = "Phone number is invalid.";
        }

        if (empty(trim($person->getUser()->getPassword()))) {
            $error['password'] = "Please enter a password.";
        } elseif (strlen($person->getUser()->getPassword()) < 7) {
            $error['password'] = "The password is too short.";
        }

        if (empty(trim($person->getUser()->getLogin()))) {
            $error['login'] = "Please enter an email";
        } elseif (!filter_var($person->getUser()->getLogin(), FILTER_VALIDATE_EMAIL)) {
            $error['login'] = "The email is not valid";
        } else { 
            $find = $this->em->getRepository("AppBundle:User")->findOneByLogin($person->getUser()->getLogin());
            if (!empty($find)) {
                $error['login'] = "The email " . $person->getUser()->getLogin() . " is already used";
            }
        }

        if (count($error) > 0) {
            return $error;
        }
        return true;
    }
    
    public function isValideTechnician(Technician $technician) { 
        $person=$technician->getPerson();
        // we call the validation data of person in personController
        $error=$this->isValidePerson($person);
         if(!is_array($error)){
             $error = [];
         }
        if (empty(trim($technician->getBusinessCard()))) {
            $error['firstName'] = "Please enter a business card.";
        }

        if (count($error) > 0) {
            return $error;
        }
        return true;
    }
}
