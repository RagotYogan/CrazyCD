<?php

namespace BackEnd\Optimisation;
class Client
{
    public string $nom;
    public array $besoins = [];

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    public function ajouterBesoin(string $type): void
    {
        $this->besoins[$type] = ["traite" => false];
    }
//
//    public function incrementerBesoinAffecte(): void {
//        $this->nbBesoinsAffectes++;
//    }

    public function setBesoinAffecte(string $type): void
    {
        $this->besoins[$type] = true;
    }

    /**
     * @return array
     */
    public function getBesoins(): array
    {
        return $this->besoins;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function resetBesoinAffecte(string $besoin)
    {
        $this->besoins[$besoin] = false;
    }
}
