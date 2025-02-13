<?php

class Affectation
{
    public array $affectations = [];
    public int $score;

    public function __construct()
    {
        $this->score = 0;
    }

    public function affecter(array $salaries, array $clients): void
    {
        $superTab = [];
        foreach ($clients as $client) {
            $besoins = $client->getBesoins();
            $first = true;
            foreach ($besoins as $besoin => $affect) {
                if (!isset($superTab[$besoin])) {
                    $superTab[$besoin] = [];
                }
                if ($first) {
                    array_unshift($superTab[$besoin], $client);
                    $first = false;
                } else {
                    $superTab[$besoin][] = $client;
                }
            }
        }
        foreach ($salaries as $salarie) {
            $salarie->trierTabComp();
            while(!$salarie->getAffecte()){
                for ($i = 0; $i < count($superTab); $i++) {
                    if ($i == count($salarie->competences ) || $salarie->getAffecte()){
                        break;
                    }
                    $type = array_keys($salarie->competences)[$i];
                    if (!empty($superTab[$type])){
                        // Ajouter dans le tableau d'affectation
                        $this->affectations[] = [$salarie, $type, $superTab[$type][0]];
                        $salarie->setAffecte(true);
                        $superTab[$type][0]->setBesoinAffecte($type);
                        // Unset dans supertab l'élément ajouté
                        array_shift($superTab[$type]);
                    }
                }
                break;
            }
        }
        foreach ($this->affectations as $affectation) {
            list($salarie, $besoin, $client) = $affectation;
            echo "Salarie: {$salarie->nom}, Besoin: {$besoin}, Client: {$client->nom}\n";
        }
        echo $this->calculerScore($this->affectations, $salaries, $clients);
    }

    /**
     * Méthode utilisant le backtracking pour affecter les salariés aux clients.
     * On cherche ici la solution qui maximise le score global.
     */
    public function affecterBacktracking(array $salaries, array $clients): void
    {
        // Préparer un tableau associatif regroupant les clients par type de besoin.
        $superTab = [];
        foreach ($clients as $client) {
            $besoins = $client->getBesoins();
            foreach ($besoins as $besoin => $affect) {
                if (!isset($superTab[$besoin])) {
                    $superTab[$besoin] = [];
                }
                // On ajoute le client dans la liste pour ce besoin.
                $superTab[$besoin][] = $client;
            }
        }

        // Initialisation des variables pour le backtracking.
        $bestSolution = [];   // Contiendra la meilleure affectation trouvée.
        $bestScore = -INF;     // Score de la meilleure solution.
        $currentAssignments = []; // Affectation courante (tableau d'affectations)

        // Démarrer le backtracking à partir du premier salarié (index 0)
        $this->backtrack(0, $salaries, $superTab, $currentAssignments, $bestSolution, $bestScore);

        // Sauvegarder la solution trouvée dans l'attribut de la classe.
        $this->affectations = $bestSolution;

        // Affichage du résultat.
        foreach ($bestSolution as $assignment) {
            list($salarie, $besoin, $client) = $assignment;
            echo "Salarie: {$salarie->nom}, Besoin: {$besoin}, Client: {$client->nom}\n";
        }
        echo "Score final: " . $bestScore;
    }

    /**
     * Fonction de backtracking récursive.
     *
     * @param int   $index               Index du salarié en cours d'affectation.
     * @param array $salaries            Tableau des salariés.
     * @param array &$superTab           Tableau associatif des clients disponibles par besoin.
     * @param array $currentAssignments  Affectations effectuées jusqu'ici.
     * @param array &$bestSolution       Référence vers la meilleure solution trouvée.
     * @param float &$bestScore          Référence vers le meilleur score obtenu.
     */
    private function backtrack(
        int $index,
        array $salaries,
        array &$superTab,
        array $currentAssignments,
        array &$bestSolution,
        float &$bestScore
    ): void {
        // Si tous les salariés ont été traités, évaluer la solution complète.
        if ($index >= count($salaries)) {
            // Calculer le score de la solution courante.
            $score = $this->calculerScore($currentAssignments, $salaries, []);
            // Remarque : si votre fonction calculerScore a besoin des clients, vous pouvez les passer ici.
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestSolution = $currentAssignments;
            }
            return;
        }

        $salarie = $salaries[$index];
        $aUneAffectation = false; // Pour vérifier si une affectation a été faite pour ce salarié

        // Pour chaque compétence (besoin) du salarié, essayer de l’affecter à un client disponible.
        foreach ($salarie->competences as $besoin => $compValue) {
            // Vérifier s’il existe des clients disponibles pour ce besoin.
            if (isset($superTab[$besoin]) && count($superTab[$besoin]) > 0) {
                // Pour chaque client disponible pour ce besoin, essayer l’affectation.
                $availableClients = $superTab[$besoin];
                for ($j = 0; $j < count($availableClients); $j++) {
                    // Récupérer le client à l’index $j.
                    $client = $availableClients[$j];

                    // Retirer ce client de la liste pour ce besoin afin d’éviter une double affectation dans cette branche.
                    array_splice($superTab[$besoin], $j, 1);

                    // Ajouter l'affectation (salarie, besoin, client) dans la solution courante.
                    $currentAssignments[] = [$salarie, $besoin, $client];

                    // Appeler récursivement pour le salarié suivant.
                    $this->backtrack($index + 1, $salaries, $superTab, $currentAssignments, $bestSolution, $bestScore);

                    // Annuler l’affectation (backtracking) :
                    array_pop($currentAssignments);
                    // Réinsérer le client à sa position initiale dans la liste.
                    array_splice($superTab[$besoin], $j, 0, [$client]);

                    $aUneAffectation = true;
                }
            }
        }

        // Optionnel : si aucune affectation n'a été faite pour ce salarié (ou si l’on souhaite autoriser le non-assignment),
        // on peut aussi passer au salarié suivant sans lui affecter de client.
        $this->backtrack($index + 1, $salaries, $superTab, $currentAssignments, $bestSolution, $bestScore);
    }



    public function calculerScore(array $affectationCourante, $salaries, $clients): int
    {
        // Tester si tous les salariés sont affectés
        foreach ($salaries as $salarie) {
            if (!$salarie->getAffecte()) {
                $this->score -= 10;
            }
        }
        // Cas normal
        // On parcourt les clients en comptant le nombre de tache affectees pour un meme client
        foreach ($clients as $client) {
            $countAffectees = 0;
            foreach ($client->besoins as $besoin => $affect) {
                if ($affect) {
                    foreach ($affectationCourante as $affectation) {
                        if ($affectation[2]->nom === $client->nom && $affectation[1] == $besoin) {
                            $this->score += $affectation[0]->getInteret($affectation[1]) - ($countAffectees);
                            $countAffectees++;
                        }
                    }
                }
            }
            // Si le compteur de taches affectees est a 0, on enleve 10 points
            if ($countAffectees == 0) {
                $this->score -= 10;
            }
        }
        return $this->score;
    }
}