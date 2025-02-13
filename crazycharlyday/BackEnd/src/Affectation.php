<?php

class Affectation
{
    public array $affectations = [];
    public int $score;

    public function __construct()
    {
        $this->score = 0;
    }

    public function affecter(array $salaries, array $clients): array
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
        usort($salaries, function ($a, $b) {
            return count($a->competences) - count($b->competences);
        });
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
        return $this->affectations;
    }

    public function compareCompetenceSize(int $size1, int $size2): bool {
        return $size1 > $size2;
    }


    public function calculerScore(array $affectationCourante, $salaries, $clients): int
    {
        $this->score = 0;
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