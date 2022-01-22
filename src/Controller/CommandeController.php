<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\EtatCommande;
use App\Entity\DetailsCommande;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetailsCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }  
    
    /**
     * @Route("/api/commande", name="commande", methods={"POST"})
     */
    public function commander(Request $request,SerializerInterface $serializer, EntityManagerInterface $em,
                        ValidatorInterface $validator, UserRepository $userRepository,
                    ProduitRepository $produitRepo, CommandeRepository $comRepo ,Security $security)
    {
                $commandeJson= $request->getContent();
                $commandeTab= $serializer->decode($commandeJson, 'json')["produits"];
                $commande = new Commande();
                $prixTotal = 0;
                $user= $security->getUser();
                $commande-> setUser($user);
                $commande-> setAdresse($user->getAdress());
                $commande->setDate(new \DateTime());
          
            foreach($commandeTab as $produitItem){
                $produit=$produitRepo->find($produitItem["id"]);
                $detailsCommande = new DetailsCommande();
                $detailsCommande-> setMontant($produit->getPrix());
                $detailsCommande->setQuantiteProduit($produitItem["qtite"]);
                $detailsCommande->setTotal($produit->getPrix()*$produitItem["qtite"]);
                $detailsCommande->setCommande($commande);
                $detailsCommande->setProduit($produit);
                $prixTotal += $detailsCommande->getTotal();
               }
                $commande->setPrixTotal($prixTotal);

                $etat = new EtatCommande();
                $etat->setLibelle("En_Cours");
                $commande->setEtat($etat);
                    
                $dataCom=$comRepo->findAll();
                if($dataCom){
                    $lastCom = $dataCom[count($dataCom)-1]->getNumCommande();
                    $numActu = (substr($lastCom, -1)+1);
                    $lastCom[strlen($lastCom)-1]= $numActu;
                }
                else{
                    $lastCom = "N000001";
                }
                $commande->setNumCommande($lastCom) ;          
                $em->persist($detailsCommande);
                $em->persist($commande);
                $em= $this->getDoctrine()->getManager();
                $em->flush();
                return $this->json($commande, Response::HTTP_OK);
            }
     /**
     * @Route("/api/commande", name="commande", methods={"GET"})
     */
}

