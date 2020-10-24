<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Entity\User;
use CMS\BlogBundle\Entity\Category;

class BlogController extends Controller
{
    public function indexAction($page = 0)
    {
    	$em = $this->getDoctrine()->getManager();

    	$repo = $em->getRepository('CMSBlogBundle:Article');

    	$nb_articles =  $repo->countAll();
    	$nb_articles_par_pages = 5;

    	$nb_pages = ceil($nb_articles / $nb_articles_par_pages);

    	$offset = $page * $nb_articles_par_pages;
    	if($offset < 0){
    		$offset = 0;
    	}

    	$articles = $repo->getList($nb_articles_par_pages, $offset);

        return $this->render('blog/index.html.twig', array(
            'articles' => $articles,
            'nb_pages' => $nb_pages,
            'page' => $page,
        ));
    }

    public function debugAction($page = 0)
    {
      $em = $this->getDoctrine()->getManager();

      $repo = $em->getRepository('CMSBlogBundle:Article');

      $nb_articles =  $repo->countAll();
      $nb_articles_par_pages = 5;

      $nb_pages = ceil($nb_articles / $nb_articles_par_pages);

      $offset = $page * $nb_articles_par_pages;
      if($offset < 0){
        $offset = 0;
      }

      $articles = $repo->getList($nb_articles_par_pages, $offset);

        return $this->render('blog/debug.html.twig', array(
            'articles' => $articles,
            'nb_pages' => $nb_pages,
            'page' => $page,
        ));
    }

    public function debugArticleAction(Request $request, $slug){
    	$em = $this->getDoctrine()->getManager();

    	$article = $em->getRepository('CMSBlogBundle:Article')->findOneBy(array('slug'=> $slug));


		return $this->render('blog/article_debug.html.twig', array(
            'article' => $article,
            'originalRequest' => $request,
        ));
    }

    public function showAction(Request $request, $slug){
    	$em = $this->getDoctrine()->getManager();

    	$article = $em->getRepository('CMSBlogBundle:Article')->findOneBy(array('slug'=> $slug));


		return $this->render('blog/show.html.twig', array(
            'article' => $article,
            'originalRequest' => $request,
        ));
    }

    public function randomAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('CMSBlogBundle:Article')->random();


        return $this->render('blog/show.html.twig', array(
            'article' => $article,
            'originalRequest' => $request,
        ));

    }

    public function aboutAction(){

        $articles = $this->getDoctrine()->getManager()->getRepository('CMSBlogBundle:Article')->getAbout();
    	return $this->render('blog/about.html.twig', array('articles' => $articles));
    }

    public function searchAction(Request $request, $query, $page = 0){

        $articles = [];
        $list = [];

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CMSBlogBundle:Article');


        $result = $repo->search($query);

        $nb_articles =  count($result);
        $nb_articles_par_pages = 5;

        $nb_pages = ceil($nb_articles / $nb_articles_par_pages);

        $offset = $page * $nb_articles_par_pages;
        if($offset < 0){
            $offset = 0;
        }

        foreach ($result as $key => $value) {
            $list[] = $value['article_id'];
        }

       $articles = $repo->getList($nb_articles_par_pages, $offset, $list);



        return $this->render('blog/index_search.html.twig', array(
            'articles' => $articles,
            'nb_pages' => $nb_pages,
            'page' => $page,
        ));

    }

    public function catAction(Request $request, Category $category, $page = 0){
        //var_dump($request->get('category'));die();

        $articles = [];
        $list = [];

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CMSBlogBundle:Article');


        $nb_articles = $repo->countByCat($category);

        $nb_articles_par_pages = 5;

        $nb_pages = ceil($nb_articles / $nb_articles_par_pages);

        $offset = $page * $nb_articles_par_pages;
        if($offset < 0){
            $offset = 0;
        }


        $articles = $repo->getByCat($category, $nb_articles_par_pages, $offset);


        return $this->render('blog/index_cat.html.twig', array(
            'articles' => $articles,
            'nb_pages' => $nb_pages,
            'page' => $page,
        ));
    }
}
