<?php

namespace App\Controller;

use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{


    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, PanierService $panierSer)
    {
        $panierSer->add($id);
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, PanierService $panierSer)
    {
        $panierSer->remove($id);
    }
    /**
     * @Route("/mon-panier/supprimer/{id}", name="cart_remove_by_id")
     */
    public function delete(PanierService $panierSer, $id)
    {
        $panierSer->delete($id);
    }


    /**
     * @Route("/mon-panier/reduire/{id}", name="cart_reduire")
     */
    public function decrease(PanierService $panierSer, $id)
    {
         $panierSer->decrease($id);
    }
}
