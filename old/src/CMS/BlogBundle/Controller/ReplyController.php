<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CMS\BlogBundle\Entity\Reply;
use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Form\ReplyType;

/**
 * Reply controller.
 *
 */
class ReplyController extends Controller
{
    /**
     * Lists all Reply entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $replies = $em->getRepository('CMSBlogBundle:Reply')->findAll();

        return $this->render('reply/index.html.twig', array(
            'replies' => $replies,
        ));
    }

    /**
     * Creates a new Reply entity.
     *
     */
    public function newAction(Request $request, Article $id)
    {
        $reply = new Reply();

        $date = new \DateTime;

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $reply->setArticle($id);
        $reply->setDate($date->format('d-m-Y H:i:s'));
        $reply->setMode(false);
        $reply->setIp($request->getClientIp());
        $reply->setAuthor($user);

        $form = $this->createForm('CMS\BlogBundle\Form\ReplyType', $reply, array('action' => $this->generateUrl('reply_new', array('id' => $id->getId() ) )));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();

            return $this->redirectToRoute('cms_blog_view', array('slug' => $id->getSlug()));
        }

        return $this->render('reply/new.html.twig', array(
            'reply' => $reply,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reply entity.
     *
     */
    public function showAction(Reply $reply)
    {
        $deleteForm = $this->createDeleteForm($reply);

        return $this->render('reply/show.html.twig', array(
            'reply' => $reply,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Reply entity.
     *
     */
    public function editAction(Request $request, Reply $reply)
    {
        $deleteForm = $this->createDeleteForm($reply);
        $editForm = $this->createForm('CMS\BlogBundle\Form\ReplyType', $reply);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();

            return $this->redirectToRoute('reply_edit', array('id' => $reply->getId()));
        }

        return $this->render('reply/edit.html.twig', array(
            'reply' => $reply,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Reply entity.
     *
     */
    public function deleteAction(Request $request, Reply $reply)
    {
        $form = $this->createDeleteForm($reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reply);
            $em->flush();
        }

        return $this->redirectToRoute('reply_index');
    }

    /**
     * Creates a form to delete a Reply entity.
     *
     * @param Reply $reply The Reply entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reply $reply)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reply_delete', array('id' => $reply->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
