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
}
