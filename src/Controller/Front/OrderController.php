<?php

namespace App\Controller\Front;

use DateTime;
use DateTimeZone;
use App\Entity\Commande;
use App\Entity\LigneCommande;
// use App\Entity\OrderDetails;
use App\Repository\CommandeRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;;


class OrderController extends AbstractController
{

    #[Route('/order', name: 'order')]
    public function myOrders(CommandeRepository $commandeRepository, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        // $allMyOrders = $orderRepository->findByClient($user->getClient());
        $commande = $commandeRepository->findBy(
            ['client' => $user->getClient()],
            ['id' => 'DESC']
        );

        return $this->render('order/index.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/order/ajout', name: 'add_order')]
    public function add(SessionInterface $session, Request $request, LivreRepository $livreRepository, EntityManagerInterface $em): Response
    {

        $panier = $session->get('panier', []);
        $user = $this->getUser();

        if (!$user) {
           return $this->redirectToRoute('app_login');
        }

        if ($panier === []) {
            $this->addFlash('warning', 'Votre panier est vide');
            return $this->redirectToRoute('main');
        }

        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $phone = $request->request->get('telephone');
        $address = $request->request->get('address');



        $commande = new Commande();

        // for show in create order
        $data = [];
        $initialTotal = 0;
        foreach ($panier as $id => $quantity) {
            $livre = $livreRepository->find($id);

            $data[] = [
                'livre' => $livre,
                'quantity' => $quantity
            ];

            $initialTotal += $livre->getPrice() * $quantity;
        }


        if ($request->isMethod('POST') && $request->request->has('submit_button')) {

            // On remplit la commande
            $commande->setClient($user->getClient());
            $commande->setNom($nom);
            $commande-> setPrenom($prenom);
            $commande->setPhone($phone);
            $commande->setAddress($address);
            $commande->setStatus(false);

            $currentDateTime = new \DateTimeImmutable('now', new \DateTimeZone('Africa/Casablanca'));
            $commande->setCreatedAt($currentDateTime);

            // $commande->setIsBySiteWeb(true);
            $totalFinal = 0;

            // On parcourt le panier pour créer les détails de commande
            foreach ($panier as $item => $quantity) {
                $ligneCommande = new LigneCommande();
                // On va chercher le produit
                $livre = $livreRepository->find($item);
                $price = $livre->getPrice();
                // $livre->setQuantity($livre->getQuantity() - $quantity);
                // On crée le détail de commande
                $ligneCommande->setPrice($price);
                $ligneCommande->setQuantite($quantity);

    
                $commande->addLigneCommande($ligneCommande);
                $totalFinal += ($price * $quantity);
            }

            $commande->setTotal($totalFinal);
            // On persiste et on flush
            $em->persist($commande);
            $em->flush();
            $reference = 'order-00' . $commande->getId();
            $commande->setReference($reference);
            $em->persist($commande);
            $em->flush();

            $session->remove('panier');

            $this->addFlash('success', 'Commande créée avec succès');
        }

        return $this->render('order/new.html.twig', [
            'data' => $data,
            'initialTotal' => $initialTotal
        ]);
    }
    #[Route('order/details/{id}', name: 'order_details')]
    public function myOrderDetail(Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $user = $this->getUser();
        $clientConnected = $this->getUser()->getClient();
        if (!$user) {
            return $this->redirectToRoute('home');
        }
        /* check if order not in my orders */
        if ($clientConnected != $commande->getClient()) {
            return $this->redirectToRoute('order');
        }

        $cmd = $commandeRepository->find($commande);

        return $this->render('order/detail.html.twig', [
            'commande' => $cmd,
        ]);
    }
 
}
