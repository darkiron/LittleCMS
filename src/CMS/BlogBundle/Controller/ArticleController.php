<?php

namespace CMS\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Entity\Image;
use CMS\BlogBundle\Form\ArticleType;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('CMSBlogBundle:Article')->findBy(array(),array('id' =>'DESC'));

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Finds and displays a Article entity.
     *
     */
    public function showAction(Article $article)
    {

        return $this->render('article/show.html.twig', array(
            'article' => $article,
        ));
    }

    public function editAction(Request $request, Article $article){

    

        $user = $this->getUser();

        $images = $this->getDoctrine()->getManager()->getRepository('CMSBlogBundle:Image')->findAll();
      
        $form = $this->createForm(ArticleType::class, $article)
            ->add('save', SubmitType::class, array('label' => 'Create Article'))
            ;
            //->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $article->setSlug(str_replace(' ', '_' , $article->getTitle())); 
            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            $this->fullText($article);

            return $this->redirectToRoute('article_show', array('id'=> $article->getId()));
        }

        return $this->render('article/new.html.twig', array(
                'form' => $form->createView(),'images'=> $images,
            ));

    }

    public function newAction(Request $request){
        // create a task and give it some dummy data for this example
        $article = new Article();

        $images = $this->getDoctrine()->getManager()->getRepository('CMSBlogBundle:Image')->findAll();

        $user = $this->getUser();
        
       
        $article->setDatecreation(new \DateTime());
        $article->setDatePublication(new \DateTime());
        $article->setUser($user);
        $form = $this->createForm(ArticleType::class, $article)
            ->add('save', SubmitType::class, array('label' => 'Create Article'))
            ;


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $article->setSlug(str_replace(' ', '_' , $article->getTitle())); 
            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            $this->fullText($article);

            return $this->redirectToRoute('article_show', array('id'=> $article->getId() ));
        }

            return $this->render('article/new.html.twig', array(
                'form' => $form->createView(),'images'=> $images
            ));
        }

    private function fullText($article){
        if ($this->check_fullText($article->getId())){
            return $this->update_fullText($article);
        }
        else{
            return $this->insert_fullText($article);
        }
    }

    private function check_fullText($id){
        $em = $this->getDoctrine()->getManager();

        $old_sql = $em->getConnection();

        $data = array('id' => $id);
        $return = $old_sql->query('SELECT article_id FROM search WHERE article_id = '.$id)->fetch();

        if (is_array($return) && array_key_exists('article_id', $return)){
            return true;
        }

        return false;
    }

    private function update_fullText($article){
        $em = $this->getDoctrine()->getManager();

        $old_sql = $em->getConnection();

        $data = array('titre' => $article->getSlug().' '.$article->getTitle(), 'description' => $article->getMetadescription().' '.$article->getDescription());
        return $old_sql->update('search',$data, array('article_id' => $article->getId()));

    }

    private function insert_fullText($article){
        $em = $this->getDoctrine()->getManager();

        $old_sql = $em->getConnection();

        $data = array('article_id' => $article->getId(), 'titre' => $article->getSlug().' '.$article->getTitle(), 'description' => $article->getMetadescription().' '.$article->getDescription());
        return $old_sql->insert('search',$data);

    }
}
