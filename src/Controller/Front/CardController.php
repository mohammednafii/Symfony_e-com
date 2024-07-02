<?php

namespace App\Controller\Front;

use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LivreRepository;


class CardController extends AbstractController
{
    private $livreRepository;
    public function __construct(LivreRepository $livreRepository)
    {
        $this->livreRepository = $livreRepository;
    }

    #[Route('/card', name: 'app_card')]
    public function index(SessionInterface $session, LivreRepository $livreRepository)
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $livre = $livreRepository->find($id);
            $dataPanier[] = [
                "livre" => $livre,
                "quantite" => $quantite
            ];
            $total += $livre->getPrice() * $quantite;
        }

        return $this->render('card/index.html.twig', compact("dataPanier", "total"));
    }
    #[Route('/add/{id}', name: 'add')]
    public function add(Livre $livre, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $livre->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        // On sauvegarde dans la session
        $session->set("panier", $panier);
        return $this->redirectToRoute('app_card');
    }

    #[Route('/remove/{id}', name : 'remove')]
    public function remove(Livre $livre, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $livre->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }
        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_card");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Livre $livre, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $livre->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }
}
