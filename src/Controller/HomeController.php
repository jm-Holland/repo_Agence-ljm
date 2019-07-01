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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\MailerService;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="home_index",methods={"GET","POST"})
     *
     */
    public function index(ArticleRepository $articles, ReferenceRepository $references, ServiceRepository $services, Request $request, MailerService $mailerService): Response
    {
        if (!$this->session->has('value')) {
            $customer = new Customer();
        } else {
            $customer = $this->session->get('value');
        }
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            try {
                $mailerService->postMail($customer);
                $this->addFlash('success', 'Votre demande ' . $customer->getSubject() . 'a bien été envoyé, vous allez recevoir un email de confirmation sur ' . $customer->getEmail());
            } catch (\Exception $e) {
                throw new \Exception('warning', 'Une erreur est survenue lors de l\'envoi de l\'email,merci de refaire votre demande');
            }
            return $this->redirectToRoute('home_index');
        }
        return $this->render('home/index.html.twig', [
            'articles'      => $articles->findLast(3),
            'references'    => $references->findLast(5),
            'allreferences' => $references->findAll(),
            'services'      => $services->findAll(),
            'form'          => $form->createView(),
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

    /**
     * Verification of the current session
     *
     * @return Response
     */
    public function verifSession(): Response
    {
        // Verification of the current session otherwise error
        if (!$this->session->has('value')) {
            $this->addFlash('danger', "An error has occurred, thank you to renew your request !");
            return $this->redirectToRoute('home_index');
        }
        $valueSession = $this->session->get('value');
        return $valueSession;
    }
}
