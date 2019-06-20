<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\ReferenceRepository;
use App\Repository\ServiceRepository;
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
     * @param ArticleRepository $article
     * @param ReferenceRepository $reference
     * @return Response
     */
    public function index(ArticleRepository $article,ReferenceRepository $reference, ServiceRepository $service): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $article->findLast(3),
            'references' => $reference->findLast(5),
            'allreferences' => $reference->findAll(),
            'services' => $service->findAll()
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
