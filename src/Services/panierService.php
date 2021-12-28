<?php

namespace App\Services;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{

    protected $session;
    protected $produitRepository;


    /**
     * Constructeur de la class panier outils
     *
     * @param SessionInterface $session
     * @param ProduitRepository $produitRepository
     */
    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }

    /**
     * Ajouter produit(s) au panier
     *
     * @param integer $id
     * @return void
     */
    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    /**
     * Supprime élément(s) du panier
     *
     * @param integer $id
     * @return void
     */
    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    /**
     * Contenu du panier 
     *
     * @return array
     */
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'produit' => $this->produitRepository->find($id),
                'quantite' => $quantity
            ];
        }
        return $panierWithData;
    }

    /**
     * Total du panier
     *
     * @return float
     */
    public function getTotalTTC(): float
    {
        $Prixtotal = 0;

        foreach ($this->getFullCart() as $item) {
            $Prixtotal += $item['produit']->getPrixUnité() * $item['quantite'];
        }
        return $Prixtotal;
    }

    /**
     * Nb d'article du panier
     *
     * @return int
     */
    public function getTotalItem()
    {
        $Prixtotal = 0;

        foreach ($this->getFullCart() as $item) {
            $Prixtotal += $item['quantite'];
        }
        return $Prixtotal;
    }


}
