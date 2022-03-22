<?php

namespace App\Controller\admin;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_USER")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/dashboard/services", name="service_index")
     * @param ServiceRepository $services
     * @return Response
     */
    public function index(ServiceRepository $services)
    {
        return $this->render('admin/service/index.html.twig', [
            'services' => $services->findAll()
        ]);
    }

    /**
     * @Route("/service/new", name="service_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            $this->addFlash('success', "Votre service a bien été enregistré!");
            return $this->redirectToRoute('service_index');
        }
        return $this->render('admin/service/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/service/{id}", methods={"GET"}, name="service_show")
     * @param Service $service
     * @return Response
     */
    public function show(Service $service): Response
    {
        return $this->render('admin/service/show.html.twig', [
            'service' => $service,
        ]);
    }

    /**
     * @Route("/service/{id}/edit", name="service_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Service $service
     * @return Response
     */
    public function edit(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            $this->addFlash('success', 'Service mis à jour');

            return $this->redirectToRoute('service_show', [
                'id' => $service->getId(),
            ]);
        }
        return $this->render('admin/service/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/service/{id}/delete", name="service_delete", methods={"DELETE"})
     * @param Request $request
     * @param Service $service
     * @return Response
     */
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_index');
    }
}
