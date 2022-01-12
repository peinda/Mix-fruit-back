<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Classe\PanierService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route
     *(path="/commande", name="commande", methods={"POST"},
     * defaults={
     *     "_controller"="\app\Controller\CommandeController::commander",
     *     "_api_resource_class"=Commande::class,
     *     "_api_collection_operation_name"="commande",
     *    }
     * )
     */
    public function commander(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,
                                     ValidatorInterface $validator, UserRepository $userRepository, PanierService $panierService, Security $security)
    {

        $commandeJson= $request->getContent();
        dd($request->getContent());
         $commandeTab= $serializer->decode($commandeJson, 'json');
         $commande = new Commande();
         $user= $security->getUser();
         //dd($user);
         $idUserCom= $user->getId();
         $idUserCom= $userRepository->find($idUserCom);
         $commande->setDateLivraison(new \DateTime());
         $commande->setAdresse($adresse);

         $prixTotal=$panierService->getTotal()($prixTotal);
         $commande->setPrixTotal($prixTotal);
         
         $commande->setQuantitéPrduit($quantitéPrduit);
         $commande->setMontant($montant);
         $produit=$panierService->getFullCart($produit);
         $commande->setProduits($produit);

            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist( $commandeJson);
            $entityManager->flush();
            return $this->json($commande, Response::HTTP_OK);
        }

}
