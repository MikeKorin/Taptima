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
     * @var object
     */
    private $bookInjection;
    private $authorInjection;

    public function __construct
    (
        AuthorService $authorService
    )
    {
        $this->authorInjection  = $authorService->getAuthorEntity();
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     * @Route("/author/form")
     */
    public function authorForm(Request $request,ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(AuthorForm::class,$this->authorInjection);
        
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