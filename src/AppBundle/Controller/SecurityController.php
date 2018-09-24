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
class SecurityController extends FOSRestController {
    
    /**
     * @Rest\Post("/api/authenticate")
     */
    public function getAllByTypeAction(Request $request) {

        $login= $request->get("login");
        $password= $request->get("password");
        $result=[];
        $result['error']=0;
        if(empty($login) || empty($password)){ 
            return new View($result, Response::HTTP_ACCEPTED);
        }
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->findOneBy(["login"=>$login]);
            
        if(is_null($user)){
            //login or password incorrect 
            return new View($result, Response::HTTP_ACCEPTED);
        }
        if($this->get('security.password_encoder')->isPasswordValid($user,$password)){
            $result['error']=1;
            $result['user']=$user;
            return $result;
        }else{ 
            return new View($result, Response::HTTP_ACCEPTED);
        }
            
        $restresults = $this->getDoctrine()->getRepository("AppBundle:Speciality")->findBy(["speciality_type"=>$id_speciality_type]);
//        if (empty($restresults)) {
//            return new View("there are no Speciality existe", Response::HTTP_NOT_FOUND);
//        }

        return $restresults;
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
