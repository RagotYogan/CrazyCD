<?php

namespace BackEnd\infrastructure;

use BackEnd\Optimisation\Readers;
use BackEnd\Optimisation\Affectation;
use BackEnd\Optimisation\Builders;

class OptiRepository
{
    public function save($filePath): array
    {
        // Lire les données du CSV
        $data = Readers::lireCsv($filePath);

        // Récupérer les objets Clients et Salariés
        $clients = $data["clients"];
        $salaries = $data["salaries"];

        $affect = new Affectation();
        $affectation = $affect->affecter($salaries, $clients);
        $score = $affect->calculerScore($affectation, $salaries, $clients);

        // Construire la réponse JSON
        $response = [
            "score" => $score,
            "affectations" => []
        ];

        foreach ($affectation as $affect) {
            $response["affectations"][] = [
                "salarie" => $affect[0]->nom,
                "besoin" => $affect[1],
                "client" => $affect[2]->nom
            ];
        }

        return $response;
    }
}
