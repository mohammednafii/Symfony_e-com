<?php

namespace App\Controller\Front;

use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Livre;
class MainController extends AbstractController
{
    private $livreRepository;
    private $categorieRepository;

    public function __construct(LivreRepository $livreRepository ,CategorieRepository $categorieRepository)
    {
        $this->livreRepository = $livreRepository;
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/', name: 'main')]
    public function index(): Response
    {
        $livres = $this->livreRepository->findAllOrderedByReviewCount();
        $categories = $this->categorieRepository->findAll(); 

        return $this->render('main/index.html.twig', [
            'livres' => $livres ,
            'categories' =>  $categories,
            ]);
    }
    #[Route('/{categorie_id}', name: 'bookcategory', requirements: ['categorie_id' => '\d+'])]
    public function show(int $categorie_id): Response
    {
        $categorie = $this->categorieRepository->find($categorie_id);
        $categorie_livre = $this->livreRepository->findBy(['categorie' => $categorie_id ]);

        return $this->render('category.html.twig', [
            'categorie_livre' => $categorie_livre,
            'categorie' => $categorie,
        ]);
    }
    
}
