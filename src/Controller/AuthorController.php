<?php


namespace App\Controller;


use App\Entity\Authors;
use App\Entity\Books;
use App\Form\AuthorForm;
use App\Form\BookForm;
use App\Service\AuthorService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorController
 * @package App\Controller
 */
class AuthorController extends AbstractController
{

    /**
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param AuthorService $authorService
     * @return Response
     * @Route("/author/form")
     */
    public function authorForm(Request $request,ManagerRegistry $doctrine, AuthorService $authorService): Response
    {
        $form = $this->createForm(AuthorForm::class, $authorService);
        $form->handleRequest($request);
        $AuthorForm = $form->getData();

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager -> persist($AuthorForm);
            $entityManager -> flush();

            return $this->redirectToRoute("bookController");
        }

        return $this->render('author/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @return Response
     * @Route("/author/delete/{id}")
     */
    public function deleteAuthor(int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $author          = $entityManager->getRepository(Authors::class)->find($id);
        $entityManager ->remove($author);
        $entityManager ->flush();

        return $this->redirectToRoute("authorController");
    }

    /**
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @Route("/author/update/{id}")
     * @return Response
     */
    public function updateAuthor(int $id,ManagerRegistry $doctrine, Request $request): Response
    {

        $entityManager = $doctrine->getManager();
        $author        = $entityManager->getRepository(Authors::class)->find($id);

        $form = $this->createForm(AuthorForm::class, $author);

        $form->handleRequest($request);
        $authorForm = $form->getData();

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager -> persist($authorForm);
            $entityManager -> flush();

            return $this->redirectToRoute("authorController");
        }

        return $this->render('author/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/author/show")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function showAuthors(ManagerRegistry $doctrine): Response
    {
        $authors = $doctrine->getRepository(Authors::class)->findAll();
        return $this->render('author/show_authors.html.twig', ['authors' => $authors]);
    }
}