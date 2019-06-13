<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(ArticleRepository $article)
    {
        return $this->render('home/index.html.twig', [
            'articles' => $article->findLast(3)
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
