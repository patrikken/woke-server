<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Incident;
use AppBundle\Entity\SpecialityIncident;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of TypeSpecilityController
 *
 * @author uni2grow
 */
class IncidentController extends FOSRestController {

    /**
     * @Rest\Get("/api/incident")
     */
    public function getAllAction() {

        // here we get all the speciality type

        $restresults = $this->getDoctrine()->getRepository("AppBundle:Incident")->findAll();
//        if (empty($restresults)) {
//            return new View("there are no Speciality existe", Response::HTTP_NOT_FOUND);
//        }

        return $restresults;
    }

    /**
     * @Rest\Get("/api/incident/getforuser/{id_person}")
     */
    public function getForUserAction($id_person) {

        // here we get all the speciality type 
        $restresults = $this->getDoctrine()->getRepository("AppBundle:Incident")->findBy(["person" => $id_person],["date"=> "DESC"]);
//        if (empty($restresults)) {
//            return new View("there are no Speciality existe", Response::HTTP_NOT_FOUND);
//        } 
        return $restresults;
    }

    /**
     * @Rest\Get("/api/incident/{id_person}/{id}")
     */
    public function idAction($id, $id_person) {

        // here we get single speciality type by id

        $singleresult = $this->getDoctrine()->getRepository("AppBundle:Incident")->findOneBy(["person" => $id_person, "id" => $id]);
        if ($singleresult === null) {
            return new View(["error" => "Incident dont exist"], Response::HTTP_ACCEPTED);
        }

        return $singleresult;
    }

    /**
     * @Rest\Post("/api/incident/{id_person}")
     */
    public function postAction(Request $request, $id_person) {
        $data = new Incident();
        $description = $request->get('description');
        $id_type = $request->get('id_type');
        //we test went ever the submited data is valide
        if ($this->invalideData($description, $id_type)) {
            return new View(["error" => true, "msg" => "NULL VALUES ARE NOT ALLOWED"], Response::HTTP_OK);
        }
        $em = $this->getDoctrine()->getManager();

        $type_spec = $em->getRepository("AppBundle:TypeSpeciality")->find($id_type);
        if (empty($type_spec)) {
            return new View(["error" => true, "msg" => "Speciality Not found"], Response::HTTP_OK);
        }

        $person = $em->getRepository("AppBundle:Person")->find($id_person);
        if (empty($person)) {
            return new View(["error" => true, "msg" => "User Not found"], Response::HTTP_OK);
        }
        $data->setDescription($description);
        $data->setPerson($person);
        $speciality_inci = new SpecialityIncident();
        $speciality_inci->setIncident($data);
        $speciality_inci->setTypeSpeciality($type_spec);
        $em->persist($speciality_inci);
        $em->persist($data);
        $em->flush();
        return new View(["error" => false, "msg" => "Speciality Added Successfully"], Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/incident/{id}")
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
     * @Rest\Put("/api/incident/{id}")
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

    public function invalideData($description, $libelle) {
        if (empty(trim($description)) || empty(trim($libelle))) {
            return true;
        }
        return false;
    }

}
