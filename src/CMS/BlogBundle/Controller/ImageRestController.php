<?php
namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;

use CMS\BlogBundle\Entity\Image;
use CMS\BlogBundle\Form\ImageType;


class ImageRestController extends Controller{


  /**
   * @Rest\View()
   * @Rest\Get("api/images")
   */
   public function getImagesAction(){
     return $this->getDoctrine()
                 ->getManager()
                 ->getRepository('CMSBlogBundle:Image')
                 ->findAll()
                 ;
   }

   /**
    * @Rest\View()
    * @Rest\Get("api/image/{id}")
    */
    public function getImageAction(Request $request){
      return $this->getDoctrine()
                  ->getManager()
                  ->getRepository('CMSBlogBundle:Image')
                  ->findOneById($request->get('id'))
                  ;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("api/image/new")
     */
    public function postImageAction(Request $request){
      $image = new Image();
      $form = $this->createForm(ImageType::class, $image);

      return $request->request->all();
      $form->submit($request->request->all());

      if ($form->isValid()) {
        $article->setSlug();
        $em = $this->get('doctrine.orm.entity_manager');

        $em->persist($image);
        $em->flush();

        return $image;
      }

      return $form;
     }

    /**
    * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
    * @Rest\Delete("/api/image/{id}/delete")
    */
   public function removeImageAction(Request $request)
   {
       $em = $this->getDoctrine()->getManager();
       $image = $em->getRepository('CMSBlogBundle:Article')
                   ->findOneById($request->get('id'));

       $em->remove($image);
       $em->flush();
   }

   /**
    * @Rest\View()
    * @Rest\Put("api/image/{id}/edit")
    */
    public function updateImageAction(Request $request){
      $em = $this->getDoctrine()->getManager();

      $image = $em->getRepository('CMSBlogBundle:Image')
                    ->findOneById($request->get('id'));

      if(empty($image))
        return new JsonResponse(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);

      $form = $this->creaForm(ImageType::class, $article);

      $form->submit($request->request->all());

      if($form->isValid()){
        $em->merge($image);
        $em->flush();

        return $image;
      }

      return $form;
    }

}
