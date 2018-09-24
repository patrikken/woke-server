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

/**
 * Description of PersonController
 *
 * @author uni2grow
 */
class PersonController extends FOSRestController {

    /**
     * @Rest\Get("/api/user")
     */
    public function getAllAction() {

        // here we get all the user type

        $restresults = $this->getDoctrine()->getRepository("AppBundle:Person")->findAll();
//        if (empty($restresults)) {
//            return new View("there are no Person existe", Response::HTTP_NOT_FOUND);
//        }

        return $restresults;
    }

    /**
     * @Rest\Get("/api/user/{id}")
     */
    public function idAction($id) {

        // here we get single user type by id

        $singleresult = $this->getDoctrine()->getRepository("AppBundle:Person")->find($id);
        if ($singleresult === null) {
            return new View("Person dont exist", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }
    
    /**
     * @Rest\Get("/api/user/getLogged/{id}")
     */
    public function getLoggedAction($id) {

        // here we get single user type by id

        $singleresult = $this->getDoctrine()->getRepository("AppBundle:User")->find($id);
        if ($singleresult === null) {
            return new View("Person dont exist", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * @Rest\Post("/api/user")
     */
    public function postAction(Request $request) {

        // here we add user type by id


        $data = $this->bindRequest($request); // Hydrated object 
        //we test went ever the submited data is valide
        $errors = $this->isValide($data); 
        if (is_array($errors)) {
            $errors["status"]=false;
            return new View($errors, Response::HTTP_OK);
        }else{
            $errors=["status" => true];
        }
        $em = $this->getDoctrine()->getManager();
        $errors["msg"]="Person Added Successfully";
        //now web en code the user password
        $password = $this->get('security.password_encoder')->encodePassword($data->getUser(), $data->getUser()->getPassword());
        $data->getUser()->setPassword($password);
//        $em->persist($data->getUser());
        $em->persist($data);
        $em->flush();
        return new View($errors, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/user/{id}")
     */
    public function deleteAction($id) {

        // here we delete an user type by id

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:Person")->find($id);
        if (empty($user)) {
            return new View("Person not found", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($user);
            $em->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/user/{id}")
     */
    public function updateAction(Request $request, $id) {

        // here we delete an user type by id
        $description = $request->get('description');
        $libelle = $request->get('libelle');
        $specialytyTypeID = $request->get('id_user_type');

        //we test went ever the submited data is valide
        if ($this->invalideData($description, $libelle, $specialytyTypeID)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $specialytyType = $this->getDoctrine()->getRepository("AppBundle:Person")->find($specialytyTypeID);
        if ($specialytyType === null) {
            return new View("Person type dont exist", Response::HTTP_NOT_ACCEPTABLE);
        }

        $em = $this->getDoctrine()->getManager();
        $usertype = $em->getRepository("AppBundle:Person")->find($id);

        if (empty($usertype)) {
            return new View("Person not found", Response::HTTP_NOT_FOUND);
        }
        $usertype->setDescription($description);
        $usertype->setLibelle($libelle);
        $usertype->setPersonType($specialytyType);
        $em->flush();

        return new View("Updated successfully", Response::HTTP_OK);
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
        $user->setRole(User::ROLE_PERSON);
        $person = new Person();
        $person->setCni($request->get('cni'));
        $person->setFirstName($request->get("firstName"));
        $person->setName($request->get('name'));
        $person->setPhone($request->get('phone'));  
        $person->setUser($user);
        return $person;
    }

    public function isValide(Person $person) {
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
            $find = $this->getDoctrine()->getRepository("AppBundle:User")->findOneByLogin($person->getUser()->getLogin());
            if (!empty($find)) {
                $error['login'] = "The email " . $person->getUser()->getLogin() . " is already used";
            }
        }

        if (count($error) > 0) {
            return $error;
        }
        return true;
    }

}
