<?php
namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;

use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Form\ArticleType;


class ArticleRestController extends Controller{


  /**
   * @Rest\View()
   * @Rest\Get("api/articles")
   */
   public function getArticlesAction(){
     return $this->getDoctrine()
                 ->getManager()
                 ->getRepository('CMSBlogBundle:Article')
                 ->findAll()
                 ;
   }

   /**
    * @Rest\View()
    * @Rest\Get("api/article/{id}")
    */
    public function getArticleAction(Request $request){
      return $this->getDoctrine()
                  ->getManager()
                  ->getRepository('CMSBlogBundle:Article')
                  ->findOneById($request->get('id'))
                  ;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("api/article/new")
     */
    public function postArticleAction(Request $request){
      $article = new Article();
      $form = $this->createForm(ArticleType::class, $article);

      $form->submit($request->request->all());

      if ($form->isValid()) {
        $article->setSlug();
        $em = $this->get('doctrine.orm.entity_manager');

        $em->persist($article);
        $em->flush();

        return $article;
      }

      return $form;
     }

    /**
    * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
    * @Rest\Delete("/api/article/{id}/delete")
    */
   public function removeArticleAction(Request $request)
   {
       $em = $this->getDoctrine()->getManager();
       $article = $em->getRepository('CMSBlogBundle:Article')
                   ->findOneById($request->get('id'));

       $em->remove($article);
       $em->flush();
   }

   /**
    * @Rest\View()
    * @Rest\Put("api/article/{id}/edit")
    */
    public function updateArticleAction(Request $request){
      $em = $this->getDoctrine()->getManager();

      $article = $em->getRepository('CMSBlogBundle:Article')
                    ->findOneById($request->get('id'));

      if(empty($article))
        return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);

      $form = $this->creaForm(ArticleType::class, $article);

      $form->submit($request->request->all());

      if($form->isValid()){
        $em->merge($article);
        $em->flush();

        return $article;
      }

      return $form;
    }

}
