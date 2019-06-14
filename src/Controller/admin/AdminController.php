<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\UploaderHelper;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
}
