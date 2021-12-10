<?php
namespace App\DataPersisters;

use App\Entity\User;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    
    private $manager;
    private $encode;
    private $request;
    private $profil_id;
    private $profil_repo;
    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $encode, ProfilRepository $profil_repo)
    {
      $this->manager=$manager;
      $this->encode = $encode;
      $this->profil_repo = $profil_repo;
      $request = Request::createFromGlobals();
      if (isset(\json_decode($request->getContent(), true)['profil'])) {
          $this->profil_id = \json_decode($request->getContent(), true)['profil'];
      }else{
          $this->profil_id = 0;
      }
    }

    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
      $pwd_encoder = $this->encode->hashPassword($data, $data->getPassword());
      $data->setPassword($pwd_encoder);
      $data->setProfil($this->profil_repo->find($this->profil_id));
      strcmp($data->getProfil()->getLibelle(), 'CLIENT') == 0 || strcmp($data->getProfil()->getLibelle(), 'LIVREUR') == 0 ? $data->setUsername($data->getTel()): null;
      $this->manager->persist($data);
      $this->manager->flush();
      return $data;
    }

    public function remove($data, array $context = [])
    {
      $data->setStatut(!$data->getStatut()); 
    //   $this->manager->persist($data);
      $this->manager->flush();
      // call your persistence layer to delete $data
      return $data;
    }

    
}