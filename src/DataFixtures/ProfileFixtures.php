<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfileFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $table = ["ADMIN","GERANT","LIVREUR","CLIENT"];
        
        for ($i=0; $i < count($table); $i++) 
        {
            $profil = new Profil();
            $profil->setLibelle($table[$i]);
            $profil->setEtat(false);
            $manager->persist($profil);
            $manager->flush();
            $this->addReference($table[$i],$profil);
        }
    }
}