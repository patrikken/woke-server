<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \AppBundle\Entity\Customer;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // whatever *your* User object is
//        $user = new Customer();
//        $plainPassword = 'azertyui';
//        $em = $this->getDoctrine()->getManager(); 
//        $encoded=$this->get('security.password_encoder')->encodePassword($user, $plainPassword);
//        $user->setPassword($encoded);
//        $user->setUsername("angular");
//        $em->persist($user);
//        $em->flush();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

}
