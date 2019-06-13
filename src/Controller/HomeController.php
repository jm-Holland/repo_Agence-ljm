<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;

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
}
