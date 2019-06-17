<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/articles",methods={"GET"}, name="blog_index")
     */
    public function index(ArticleRepository $articles): Response
    {
        return $this->render('home/blog/index.html.twig', [
            'articles' => $articles->findAll()
        ]);
    }

    /**
     * @Route("/article/{id}", methods={"GET","POST"}, name="blog_show")
     */
    public function show(Request $request, Article $article): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->addComment($comment);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', "Votre commentaire est bien enregistré");
        }
        return $this->render('home/blog/post_show.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
