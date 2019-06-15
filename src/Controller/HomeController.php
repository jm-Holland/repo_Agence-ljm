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
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(ArticleRepository $article): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $article->findLast(3)
        ]);
    }

    /**
     * @Route("/articles",methods={"GET"}, name="blog_index")
     */
    public function blog_index(ArticleRepository $articles): Response
    {
        return $this->render('home/blog/index.html.twig', [
            'articles' => $articles->findAll()
        ]);
    }

    /**
     * @Route("/article/{id}", methods={"GET","POST"}, name="blog_show")
     */
    public function blog_show(Request $request, Article $article): Response
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

    /**
     * @Route("/mentions-legales", name="footer_legals")
     */
    public function legals()
    {
        return $this->render('home/footer/legals.html.twig');
    }

    /**
     * @Route("/politique-de-confidentialité", name="footer_privacy_policy")
     */
    public function privacyPolicy()
    {
        return $this->render('home/footer/privacy-policy.html.twig');
    }
}
