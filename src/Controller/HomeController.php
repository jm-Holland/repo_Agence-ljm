<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ArticleRepository;
use App\Repository\ServiceRepository;
use App\Repository\ReferenceRepository;
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
    public function index(Request $request, ArticleRepository $article, ReferenceRepository $reference, ServiceRepository $service): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', "Votre demande a bien été enregistrée.");
            return $this->redirectToRoute('home_index');
        }

        return $this->render('home/index.html.twig', [
            'articles' => $article->findLast(3),
            'references' => $reference->findLast(5),
            'allreferences' => $reference->findAll(),
            'services' => $service->findAll(),
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
