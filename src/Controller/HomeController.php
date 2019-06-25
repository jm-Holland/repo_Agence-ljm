<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
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
     *
     */
    public function index(Request $request, ArticleRepository $articles, ReferenceRepository $references, ServiceRepository $services): Response
    {

        $customer = new Customer();

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();


            return $this->redirectToRoute('home_index' . '#contact');
        }

        return $this->render('home/index.html.twig', [
            'form'          => $form->createView(),
            'articles'      => $articles->findLast(3),
            'references'    => $references->findLast(5),
            'allreferences' => $references->findAll(),
            'services'      => $services->findAll(),

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
