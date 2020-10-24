<?php 
// src/AppBundle/Controller/RegistrationController.php
namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CMS\BlogBundle\Form\UserType;
use CMS\BlogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProfileController extends controller{

	  public function showAction(Request $request){
    	$em = $this->getDoctrine()->getManager();

    	$user = $this->getUser();

    	

		
		return $this->render('registration/show.html.twig', array(
            'user' => $user,
        ));
    }
}