<?php

namespace App\DataFixtures;

use App\Entity\EtatCommande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EtatFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $table = ["En_Cours","Validé","Rejeté","Livré"];
        
        for ($i=0; $i < count($table); $i++) 
        {
            $etatCommande = new EtatCommande();
            $etatCommande->setLibelle($table[$i]);
            $manager->persist($etatCommande);
            $manager->flush();
            $this->addReference($table[$i],$etatCommande);
        }
    }
}