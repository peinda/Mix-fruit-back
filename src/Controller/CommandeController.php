<?php

namespace App\Controller;

use App\Classe\PanierService;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function recap(PanierService $panierSer, Request $request): Response
    {
          $date = new \DateTime();

            $commande = new Commande();
            $reference = $date->format('dmY') . '-' . uniqid();
            $commande->setUser($this->getUser());
            $commande->setDataLivraison($date);
            $commande->setPrixTotal($prixTotal->getPrixTotal());

            $this->em->persist($commande);

            foreach ($panierSer->getFullCart() as $produit) {
                $commandeDetails = new DetailCommande();
                $commandeDetails->setCommande($commande);
                $commandeDetails->setProduit($produit['produit']->getNom());
                $commandeDetails->setQuantite($produit['quantite']);
                $commandeDetails->setPrixUnité($produit['produit']->getPrixTotal());
                $commandeDetails->setPrixTotal($produit['produit']->getPrixUnité() * $produit['quantite']);
                $this->em->persist($commandeDetails);
            }


            $this->em->flush();
           
    }
}

