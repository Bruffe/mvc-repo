<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookControllerJSON extends AbstractController
{
    #[Route('/api/library/books', name: 'lib_show_all_json')]
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/library/book/{isbn}', name: 'lib_show_one_json')]
    public function showBookByIsbn(
        BookRepository $bookRepository,
        int $isbn
    ): Response {
        $book = $bookRepository
            // ->find($id);
            ->findOneBy(['isbn' => $isbn]);

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
