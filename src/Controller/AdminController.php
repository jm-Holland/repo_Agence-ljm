<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/DashBoard", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/articles", name="article_liste")
     */
    public function listeArticles(ArticleRepository $articles)
    {
        return $this->render('admin/listeArticle.html.twig', [
            'articles' => $articles->findAll()
        ]);
    }

    /**
     * @Route("/comments",name="comment_liste")
     */
    public function listeComments(CommentRepository $comments)
    {
        return $this->render('admin/listeComment.html.twig', [
            'comments' => $comments->findAll()
        ]);
    }
}
