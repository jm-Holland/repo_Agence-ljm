<?php

namespace App\Controller\admin;

use App\Entity\Reference;
use App\Form\ReferenceType;
use App\Repository\ReferenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_USER")
 */
class ReferenceController extends AbstractController
{
    /**
     * @Route("/dashboard/references", name="reference_index")
     * @param ReferenceRepository $references
     * @return Response
     */
    public function index(ReferenceRepository $references)
    {
        return $this->render('admin/reference/index.html.twig', [
            'references' => $references->findAll()
        ]);
    }

    /**
     * @Route("/reference/new", name="reference_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $reference = new Reference();
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reference = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reference);
            $em->flush();
            $this->addFlash('success', "Votre référence a bien été enregistrée!");
            return $this->redirectToRoute('reference_index');
        }
        return $this->render('admin/reference/new.html.twig', [
            'reference' => $reference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reference/{id}", methods={"GET"}, name="reference_show")
     * @param Reference $reference
     * @return Response
     */
    public function show(Reference $reference): Response
    {
        return $this->render('admin/reference/show.html.twig', [
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/reference/{id}/edit", name="reference_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Reference $reference
     * @return Response
     */
    public function edit(Request $request, Reference $reference): Response
    {
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reference);
            $em->flush();
            $this->addFlash('success', 'Référence mise à jour');

            return $this->redirectToRoute('reference_show', [
                'id' => $reference->getId(),
            ]);
        }
        return $this->render('admin/reference/edit.html.twig', [
            'reference' => $reference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reference/{id}/delete", name="reference_delete", methods={"DELETE"})
     * @param Request $request
     * @param Reference $reference
     * @return Response
     */
    public function delete(Request $request, Reference $reference): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reference->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reference);
            $em->flush();
        }

        return $this->redirectToRoute('reference_index');
    }
}
