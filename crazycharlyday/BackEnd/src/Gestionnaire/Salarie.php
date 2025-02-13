<?php

class Salarie {
    private string $nom;
    private array $competences;

    public function __construct(string $nom) {
        $this->nom = $nom;
        $this->competences = [];
    }

    // Ajoute une compétence au salarié avec une note d'intérêt
    public function ajouterCompetence(string $competence, int $interet) {
        $this->competences[$competence] = $interet;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getCompetences(): array {
        return $this->competences;
    }
}
