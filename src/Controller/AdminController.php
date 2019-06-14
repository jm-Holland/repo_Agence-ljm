<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_USER")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/DashBoard", name="admin_index")
     */
    public function index(ArticleRepository $articles, CommentRepository $comments, UserRepository $users)
    {
        return $this->render('admin/index.html.twig', [
            'articles' => $articles->findAll(),
            'comments' => $comments->findAll(),
            'users' => $users->findAll()
        ]);
    }

    /**
     * @Route("/articles", name="article_liste")
     */
    public function listeArticles(ArticleRepository $articles)
    {
        return $this->render('admin/liste_article.html.twig', [
            'articles' => $articles->findAll()
        ]);
    }

    /**
     * @Route("/comments",name="comment_liste")
     */
    public function listeComments(CommentRepository $comments)
    {
        return $this->render('admin/liste_comment.html.twig', [
            'comments' => $comments->findAll()
        ]);
    }
}
