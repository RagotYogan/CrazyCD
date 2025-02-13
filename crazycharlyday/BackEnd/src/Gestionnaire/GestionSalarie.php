<?php

use BackEnd\Optimisation\Salarie;

class GestionSalaries {
    private array $salaries;
    private array $competences;

    public function __construct() {
        $this->salaries = [];
        $this->competences = [];
    }

    // Liste salariés
    public function ajouterSalarie(string $nom) {
        if (!isset($this->salaries[$nom])) {
            $this->salaries[$nom] = new Salarie($nom);
        }
    }

    // Ajoute une compétence à un salarié existant
    public function ajouterCompetenceSalarie(string $nom, string $competence, int $interet) {
        if (isset($this->salaries[$nom])) {
            $this->salaries[$nom]->ajouterCompetence($competence, $interet);
            $this->ajouterCompetence($competence); // ajout à la liste compétence si elle n'existe pas
        } else {
            echo "Salarié non trouvé: $nom\n";
        }
    }

    // Affiche de la liste des salariés et leurs compétences
    public function afficherSalaries() {
        foreach ($this->salaries as $salarie) {
            echo "Salarié: " . $salarie->getNom() . "\n";
            foreach ($salarie->getCompetences() as $comp => $interet) {
                echo " - Compétence: $comp, Intérêt: $interet\n";
            }
        }
    }

    // Ajout de compétence à la liste des compétences
    public function ajouterCompetence(string $nom) {
        if (!in_array($nom, $this->competences)) {
            $this->competences[] = $nom;
        }
    }

    public function modifierCompetence(string $ancienne, string $nouvelle) {
        $key = array_search($ancienne, $this->competences);
        if ($key !== false) {
            $this->competences[$key] = $nouvelle;
        }
    }

    public function supprimerCompetence(string $nom) {
        $this->competences = array_filter($this->competences, fn($comp) => $comp !== $nom);
    }

    public function afficherCompetences() {
        echo "Liste des compétences:\n";
        foreach ($this->competences as $competence) {
            echo " - $competence\n";
        }
    }
}
