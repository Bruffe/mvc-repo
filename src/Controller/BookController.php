<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
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
        $image = $request->get('image');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImage($image);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('lib_show_all');
    }

    #[Route('/library/show', name: 'lib_show_all')]
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            "books" => $books
        ];

        return $this->render('library/show-all.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'lib_show_one')]
    public function showOneBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        $data = [
            "book" => $book
        ];

        return $this->render('library/show-one.html.twig', $data);
    }

    #[Route('/library/delete/{id}', name: 'lib_delete_form', methods: ['GET'])]
    public function deleteForm(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            "book" => $book
        ];

        return $this->render('library/delete.html.twig', $data);
    }

    #[Route('/library/delete/{id}', name: 'lib_delete', methods: ['POST'])]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('lib_show_all');
    }

    #[Route('/library/update/{id}', name: 'lib_update_form', methods: ['GET'])]
    public function updateForm(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            "book" => $book
        ];

        return $this->render('library/update.html.twig', $data);
    }

    #[Route('/library/update/{id}', name: 'lib_update', methods: ['POST'])]
    public function updateBookById(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $title = $request->get('title');
        $author = $request->get('author');
        $isbn = $request->get('isbn');
        $image = $request->get('image');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImage($image);

        $entityManager->flush();

        return $this->redirectToRoute('lib_show_all');
    }
}
