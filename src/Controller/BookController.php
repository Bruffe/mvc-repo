<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository; #
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route("/library", name: "lib_home")]
    public function home(): Response
    {
        return $this->render('library/home.html.twig');
    }

    #[Route('/library/create', name: 'lib_create_form', methods: ['GET'])]
    public function createBookForm(): Response 
    {
        return $this->render('library/create.html.twig');
    }
    
    #[Route('/library/create', name: 'lib_create', methods: ['POST'])]
    public function createBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->get('title');
        $isbn = $request->get('isbn');
        $author = $request->get('author');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('lib_show_all');
    }
}
