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
use AppBundle\Entity\TypeSpeciality;

/**
 * Description of TypeSpecilityController
 *
 * @author uni2grow
 */
class TypeSpecilityController extends FOSRestController {

    /**
     * @Rest\Get("/api/typespeciality")
     */
    public function getAllAction() {

        // here we get all the speciality type

        $restresults = $this->getDoctrine()->getRepository("AppBundle:TypeSpeciality")->findAll();
        if ($restresults === null) {
            return new View("there are no data existe", Response::HTTP_NOT_FOUND);
        }

        return $restresults;
    }

    /**
     * @Rest\Get("/api/typespeciality/{id}")
     */
    public function idAction($id) {

        // here we get single speciality type by id

        $singleresult = $this->getDoctrine()->getRepository("AppBundle:TypeSpeciality")->find($id);
        if ($singleresult === null) {
            return new View("Speciality type dont exist", Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * @Rest\Post("/api/typespeciality")
     */
    public function postAction(Request $request) {

        // here we add speciality type by id

        $data = new TypeSpeciality();
        $code = $request->get('code');
        $libelle = $request->get('libelle');

        //we test went ever the submited data is valide
        if (empty(trim($code)) || empty(trim($libelle))) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getManager();
        $verify = $em->getRepository("AppBundle:TypeSpeciality")->findOneBy(["libelle" => $libelle]);
        if (!empty($verify)) {
            return new View("THIS LIBELLE VALUES ARE ALREADY USED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setCode($code);
        $data->setLibelle($libelle);
        $em->persist($data);
        $em->flush();
        return new View("Speciality type Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/typespeciality/{id}")
     */
    public function deleteAction($id) {

        // here we delete an speciality type by id

        $em = $this->getDoctrine()->getManager();
        $specialitytype = $em->getRepository("AppBundle:TypeSpeciality")->find($id);
        if (empty($specialitytype)) {
            return new View("Speciality type not found", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($specialitytype);
            $em->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/typespeciality/{id}")
     */
    public function updateAction(Request $request,$id) {

        // here we update an speciality type by id

        $code = $request->get('code');
        $libelle = $request->get('libelle');
        //we test went ever the submited data is valide
        if (empty(trim($code)) || empty(trim($libelle))) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $em = $this->getDoctrine()->getManager();
        $specialitytype = $em->getRepository("AppBundle:TypeSpeciality")->find($id);
        if (empty($specialitytype)) {
            return new View("Speciality type not found", Response::HTTP_NOT_FOUND);
        } else {
            $specialitytype->setCode($code);
            $specialitytype->setLibelle($libelle); 
            $em->flush();
        }
        return new View("Updated successfully", Response::HTTP_OK);
    }

}
