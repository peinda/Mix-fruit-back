<?php
namespace App\DataPersisters;

use App\Entity\Produit;
use App\Entity\Catalogue;
use App\Repository\CatalogueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class ProduitDataPersister implements ContextAwareDataPersisterInterface {

    private $manager;
    private $catalogue;

    public function __construct(EntityManagerInterface $manager, CatalogueRepository $repo)
    {
        
        $this->manager=$manager;
        $request = Request::createFromGlobals();
        if (isset(\json_decode($request->getContent(), true)['catalogue'])) {
            $this->catalogue = \json_decode($request->getContent(), true)['catalogue'];
            if (!($this->catalogue instanceof Catalogue)) {
                $this->catalogue = $repo->find($this->catalogue);
            }
        }
    }
    
    public function supports($data, array $context = []): bool
    {
       
        return $data instanceof Produit;
    }

    public function persist($data, array $context = [])
    {
        
      $data->setCatalogue($this->catalogue);
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