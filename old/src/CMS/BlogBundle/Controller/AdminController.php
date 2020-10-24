<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Entity\User;
use CMS\BlogBundle\Entity\Image;
use CMS\BlogBundle\Entity\Statique;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use CMS\BlogBundle\Form\StatiqueType;

class AdminController extends Controller
{
    public function indexAction($page = 0)
    {
        return $this->render('admin/index.html.twig', array(

        ));
    }


   public function contactAction(Request $request){

   		$stat = new Statique;

   		$form = $this->createForm(StatiqueType::class, $stat)
            		 ->add('save', SubmitType::class, array('label' => 'Create Article'))
            ;
            //->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $this->getDoctrine()->getManager()->persist($stat);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_show', array());
        }


   		return $this->render('admin/about.html.twig', array('form' => $form->createView()

        ));
   }

   public function createIndexAction(){
   		$em = $this->getDoctrine()->getManager();

   		$old_sql = $em->getConnection();

   		$articles = $em->getRepository('CMSBlogBundle:Article')->findAll();

   		foreach ($articles as $article) {
   			$data = array('article_id' => $article->getId(), 'titre' => $article->getSlug().' '.$article->getTitle(), 'description' => $article->getMetadescription().' '.$article->getDescription() );
   			$old_sql->insert('search', $data);
   		}


   		return $this->render('admin/in_search.html.twig');

   }


}
