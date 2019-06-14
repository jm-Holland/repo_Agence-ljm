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

    /**
     * @Route("/dashboard/articles", name="article_index")
     */
    public function articles_Index(ArticleRepository $articles)
    {
        return $this->render('admin/article/index.html.twig', [
            'articles' => $articles->findAll()
        ]);
    }

    /**
     * @Route("/article/{id}", methods={"GET"}, name="article_show")
     */
    public function show(Request $request, Article $article): Response
    {

        return $this->render('admin/article/show.html.twig', [
            'article' => $article,

        ]);
    }

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $article = new Article();
        $article->setAuthor($this->getUser());
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);
                $article->setImage($newFilename);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     *
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, Article $article, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['image']->getData();

            if ($uploadedFile) {
                $newFilename =  $uploaderHelper->uploadArticleImage($uploadedFile);
                $article->setImageFilename($newFilename);
            }
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article mise à jour');

            return $this->redirectToRoute('article_show', [
                'id' => $article->getId(),
            ]);
        }


        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/article/{id}/delete", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/comments",name="comment_index")
     */
    public function comments_Index(CommentRepository $comments)
    {
        return $this->render('admin/article/_comments.html.twig', [
            'comments' => $comments->findAll()
        ]);
    }
}
