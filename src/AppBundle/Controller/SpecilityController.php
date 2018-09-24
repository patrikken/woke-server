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
use AppBundle\Entity\Speciality;

/**
 * Description of TypeSpecilityController
 *
 * @author uni2grow
 */
class SpecilityController extends FOSRestController {

    /**
     * @Rest\Get("/api/speciality")
     */
    public function getAllAction() {

        // here we get all the speciality type

        $restresults = $this->getDoctrine()->getRepository("AppBundle:Speciality")->findAll();
//        if (empty($restresults)) {
//            return new View("there are no Speciality existe", Response::HTTP_NOT_FOUND);
//        }

        return $restresults;
    }
    
    /**
     * @Rest\Get("/api/speciality/type/{id_speciality_type}")
     */
    public function getAllByTypeAction($id_speciality_type) {

        // here we get all the speciality type

        $restresults = $this->getDoctrine()->getRepository("AppBundle:Speciality")->findBy(["speciality_type"=>$id_speciality_type]);
//        if (empty($restresults)) {
//            return new View("there are no Speciality existe", Response::HTTP_NOT_FOUND);
//        }

        return $restresults;
    }
    

    /**
     * @Rest\Get("/api/speciality/{id}")
     */
    public function idAction($id) {

        // here we get single speciality type by id

        $singleresult = $this->getDoctrine()->getRepository("AppBundle:Speciality")->find($id);
        if ($singleresult === null) {
            return new View("Speciality dont exist", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * @Rest\Post("/api/speciality")
     */
    public function postAction(Request $request) {

        // here we add speciality type by id

        $data = new Speciality();
        $description = $request->get('description');
        $libelle = $request->get('libelle');
        $specialytyTypeID = $request->get('id_speciality_type');

        //we test went ever the submited data is valide
        if ($this->invalideData($description, $libelle, $specialytyTypeID)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $em = $this->getDoctrine()->getManager();

        $specialytyType = $this->getDoctrine()->getRepository("AppBundle:TypeSpeciality")->find($specialytyTypeID);
        if ($specialytyType === null) {
            return new View("Speciality type dont exist", Response::HTTP_NOT_ACCEPTABLE);
        }

        $verify = $em->getRepository("AppBundle:Speciality")->findOneBy(["libelle" => $libelle]);
        if (!empty($verify)) {
            //if the speciality already exist
            return new View("THIS LIBELLE VALUES ARE ALREADY USED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setDescription($description);
        $data->setLibelle($libelle);
        $data->setSpecialityType($specialytyType);
        $em->persist($data);
        $em->flush();
        return new View("Speciality Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/speciality/{id}")
     */
    public function deleteAction($id) {

        // here we delete an speciality type by id

        $em = $this->getDoctrine()->getManager();
        $speciality = $em->getRepository("AppBundle:Speciality")->find($id);
        if (empty($speciality)) {
            return new View("Speciality not found", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($speciality);
            $em->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/speciality/{id}")
     */
    public function updateAction(Request $request, $id) {

        // here we delete an speciality type by id
        $description = $request->get('description');
        $libelle = $request->get('libelle');
        $specialytyTypeID = $request->get('id_speciality_type');

        //we test went ever the submited data is valide
        if ($this->invalideData($description, $libelle, $specialytyTypeID)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        
        $specialytyType = $this->getDoctrine()->getRepository("AppBundle:TypeSpeciality")->find($specialytyTypeID);
        if ($specialytyType === null) {
            return new View("Speciality type dont exist", Response::HTTP_NOT_ACCEPTABLE);
        }
        
        $em = $this->getDoctrine()->getManager();
        $specialitytype = $em->getRepository("AppBundle:Speciality")->find($id);
        
        if (empty($specialitytype)) {
            return new View("Speciality not found", Response::HTTP_NOT_FOUND);
        }
        $specialitytype->setDescription($description);
        $specialitytype->setLibelle($libelle);
        $specialitytype->setSpecialityType($specialytyType);
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

}
