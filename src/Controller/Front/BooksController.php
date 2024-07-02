<?php

namespace App\Controller\Front;
use App\Controller\Livre;
use App\Controller\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BooksController extends AbstractController
{
    private $livreRepository;
    private $categorieRepository;

    public function __construct(LivreRepository $livreRepository ,CategorieRepository $categorieRepository)
    {
        $this->livreRepository = $livreRepository;
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/books', name: 'books')]
    public function categoryProducts(Request $request): Response
    {
        $livres = $this->livreRepository->findAll();

        $history = $this->livreRepository->findBy(['categorie' => 1]);
        $science = $this->livreRepository->findBy(['categorie' => 2]);
        $literature = $this->livreRepository->findBy(['categorie' => 3]);

        $categories = $this->categorieRepository->findAll(); 

        return $this->render('books/index.html.twig', [
            'history' => $history,
            'science' => $science,
            'livres' => $livres,
            'literature' => $literature,
            'categories' => $categories,
        ]);
    }
    #[Route('/books/{id}', name: 'bookshow', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $livre = $this->livreRepository->find($id);

        return $this->render('books/show.html.twig', [
            'livre' => $livre,
        ]);
    }
    
    
}
