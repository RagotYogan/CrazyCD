<?php

class Salarie {
    public string $nom;
    public bool $affecte;
    public array $competences = [];

    public function __construct(string $nom) {
        $this->nom = $nom;
        $this->affecte= false;
    }

    public function ajouterCompetence(string $type, int $interet): void {
        $this->competences[$type] = $interet;
    }

    public function getInteret(string $type) : int
    {
        if (array_key_exists($type, $this->competences)) {
            return $this->competences[$type];
        } else {
            return 0;
        }
    }

    public function getAffecte() : bool {
        return $this->affecte;
    }

    public function setAffecte(bool $affecte): void
    {
        $this->affecte = $affecte;
    }

//    public function __toString(): string
//    {
//        return $this->nom;
//    }

    public function trierTabComp():void{
        arsort($this->competences);
    }



}
