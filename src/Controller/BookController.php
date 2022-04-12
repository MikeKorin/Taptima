<?php


namespace App\Controller;


use App\Entity\Authors;
use App\Entity\Books;
use App\Form\BookForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class BookController
 * @package App\Controller
 * @Route("/books")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/form")
     */
    public function index(): Response
    {
        $book = new Books();

        $form = $this->createForm(BookForm::class, $book);
        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/me")
     * @return Response
     */
    public function showBookLibrary()
    {
        $signUpPage = $this->generateUrl('sign_up');

        $userProfilePage = $this->generateUrl('user_profile', [
            'username' => "mike",
        ]);

        $signUpPage = $this->generateUrl('sign_up', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $signUpPageInDutch = $this->generateUrl('sign_up', ['_locale' => 'nl']);
        return $this->render('book/show_books.html.twig', ['books' => $userProfilePage]);
    }


}