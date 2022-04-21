<?php


namespace App\Controller;


use App\Entity\Authors;
use App\Entity\Books;
use App\Form\BookForm;
use App\Service\AuthorService;
use App\Service\BookService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class BookController
 * @package App\Controller
 *
 */
class BookController extends AbstractController
{
    /**
     * @Route("book/form")
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param BookService $bookService
     * @return Response
     */
    public function booksForm(Request $request, ManagerRegistry $doctrine, BookService $bookService): Response
    {
        $form = $this->createForm(BookForm::class, $bookService->getBookEntity());

        $form->handleRequest($request);
        $bookForm = $form->getData();

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager -> persist($bookForm);
            $entityManager -> flush();

            return $this->redirectToRoute("bookController");
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("book/show")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function showBookLibrary(ManagerRegistry $doctrine): Response
    {
        $book = $doctrine
            ->getRepository(Books::class)
            ->findAll();

        return $this->render('book/show_books.html.twig', ['books' => $book]);
    }

    /**
     * @Route("book/delete/{id}")
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function deleteBook(int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $book          = $entityManager->getRepository(Books::class)->find($id);
        $entityManager ->remove($book);
        $entityManager ->flush();

        return $this->redirectToRoute("bookController");
    }

    /**
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return Response
     * @Route("book/update/{id}")
     */
    public function updateBook(int $id,ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $book          = $entityManager->getRepository(Books::class)->find($id);

        $form = $this->createForm(BookForm::class, $book);

        $form->handleRequest($request);
        $bookForm = $form->getData();

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager -> persist($bookForm);
            $entityManager -> flush();

            return $this->redirectToRoute("bookController");
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("test")
     */
    public function test()
    {
        return $this->render('book/test.html.twig');
    }
}