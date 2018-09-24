<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use AppBundle\Entity\Technician;
use AppBundle\Tools\ValidateData;

/**
 * Description of PersonController
 *
 * @author uni2grow
 */
class TechnicianController extends FOSRestController {

    /**
     * @Rest\Get("/api/technician")
     */
    public function getAllAction() {

        // here we get all the user type

        $restresults = $this->getDoctrine()->getRepository("AppBundle:Technician")->findAll();
//        if (empty($restresults)) {
//            return new View("there are no Person existe", Response::HTTP_NOT_FOUND);
//        }

        return $restresults;
    }

    /**
     * @Rest\Get("/api/technician/{id}")
     */
    public function idAction($id) {

        // here we get single user type by id

        $singleresult = $this->getDoctrine()->getRepository("AppBundle:Technician")->find($id);
        if ($singleresult === null) {
            return new View("Technician dont exist", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * @Rest\Post("/api/technician")
     */
    public function postAction(Request $request) {

        // here we add user type by id


        $technician = $this->bindRequest($request); // Hydrated object  
        $em = $this->getDoctrine()->getManager();
        //we test went ever the submited data is valide
        $validator= new ValidateData($em);
        $errors = $validator->isValideTechnician($technician);  
        if (is_array($errors)) {
            return new View($errors, Response::HTTP_NOT_ACCEPTABLE);
        } 
        $data=$technician->getPerson(); 
        
        //now web en code the user password
        $password = $this->get('security.password_encoder')->encodePassword($data->getUser(), $data->getUser()->getPassword());
        $data->getUser()->setPassword($password);
        
        $em->persist($technician);
        $em->flush();
        return new View("Technician Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/technician/{id}")
     */
    public function deleteAction($id) {

        // here we delete an user type by id

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:Technician")->find($id);
        if (empty($user)) {
            return new View("Technician not found", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($user);
            $em->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/technician/{id}")
     */
    public function updateAction(Request $request, $id) {

        // here we delete an user type by id 

        return new View("Not yiet implemented", Response::HTTP_VERSION_NOT_SUPPORTED);
    }

    /*
     * Test if the subminted are invalid
     */

    public function invalideData($description, $libelle, $specialytyTypeID) {
        if (empty(trim($description)) || empty(trim($libelle)) || empty(trim($specialytyTypeID))) {
            return true;
        }
        return false;
    }

    public function bindRequest(Request $request) {
        $user=new User();
        $user->setLogin($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setRole(User::ROLE_PRO);
        $person = new Person();
        $person->setCni($request->get('cni'));
        $person->setFirstName($request->get("firstName"));
        $person->setName($request->get('name'));
        $person->setPhone($request->get('phone'));  
        $person->setUser($user);
        $technician= new Technician();
        $technician->setBusinessCard($request->get('businessCard'));
        $technician->setPerson($person);
        return $technician;
    }
 

}
