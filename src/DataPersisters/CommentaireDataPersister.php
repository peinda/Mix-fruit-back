<?php
namespace App\DataPersisters;

use App\Entity\Commentaire;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentaireDataPersister implements ContextAwareDataPersisterInterface {

    private $manager;
    private $tokenStorage;
    private $produit;

    public function __construct(EntityManagerInterface $manager, TokenStorageInterface $tokenStorageo, ProduitRepository $repo)
    {
        $this->manager=$manager;
        $this->tokenStorage = $tokenStorageo;
        $request = Request::createFromGlobals();
        if (isset(\json_decode($request->getContent(), true)['produit'])) {
            $produit_id = \json_decode($request->getContent(), true)['produit'];
            $this->produit = $repo->find($produit_id);
        }
    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commentaire;
    }

    public function persist($data, array $context = [])
    {
      $data->setUser($this->tokenStorage->getToken()->getUser());
      $data->setProduit($this->produit);
      $this->manager->persist($data);
      $this->manager->flush();
      return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->manager->remove($data);
        $this->manager->flush();
    }
}