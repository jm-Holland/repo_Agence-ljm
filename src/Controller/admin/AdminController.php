<?php

namespace App\Controller\admin;

use App\Repository\ReferenceRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\CustomerRepository;
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
    public function index(ArticleRepository $articles, CommentRepository $comments, UserRepository $users, CustomerRepository $customers,
                          ReferenceRepository $references, ServiceRepository $services)
    {
        return $this->render('admin/index.html.twig', [
            'articles'  => $articles->findAll(),
            'comments'  => $comments->findAll(),
            'users'     => $users->findAll(),
            'customers'   => $customers->findall(),
            'references' => $references->findAll(),
            'services' => $services->findAll()
        ]);
    }
}
