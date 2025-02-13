<?php

class Affectation
{
    public array $affectations = []; // List<Tuple<String, String>>
    public int $score;

    public function __construct()
    {
        $this->score = 0;
    }

    public function affecter(array $salaries, array $clients)
    {
        foreach ($clients as $client) {
            $besoins = $client->getBesoins();
            foreach ($besoins as $besoin => $affect) {
                $interetMax = PHP_INT_MIN;
                $salarieMax = null;
                foreach ($salaries as $salarie) {
                    $interet = $salarie->getInteret($besoin);

                    if ($interet > $interetMax && !$salarie->getAffecte()) {
                        $interetMax = $interet;
                        $salarieMax = $salarie;
                    }
                }
                if ($salarieMax !== null) {
                    echo "Le meilleur salarié est {$salarie}\n";

                    // Ajouter dans le tableau d'affectation
                    $affectations[] = [$salarieMax, $besoin, $client];
                    $salarieMax->setAffecte(true);
                    $client->setBesoinAffecte($besoin);
                } else {
                    echo "Aucun salarié trouvé pour le besoin $besoin\n";
                }
            }
        }
        foreach ($affectations as $affectation) {
            list($salarie, $besoin, $client) = $affectation;
            echo "Salarie: {$salarie->nom}, Besoin: {$besoin}, Client: {$client->nom}\n";
        }
        echo $this->calculerScore($affectations, $salaries, $clients);
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