<?php

class Readers
{
    public static function lireJson(string $fichier): array {
        $clients = [];
        $salaries = [];

        // Lire le contenu du fichier JSON
        if (!file_exists($fichier)) {
            throw new Exception("Fichier introuvable : $fichier");
        }

        $contenu = file_get_contents($fichier);
        $data = json_decode($contenu, true);

        if ($data === null) {
            throw new Exception("Erreur de décodage JSON : " . json_last_error_msg());
        }

        // Traiter les clients et leurs besoins
        if (isset($data["clients"])) {
            foreach ($data["clients"] as $clientData) {
                $nom = trim($clientData["nom"]);
                if (!isset($clients[$nom])) {
                    $clients[$nom] = new Client($nom);
                }

                foreach ($clientData["besoins"] as $typeBesoin) {
                    $clients[$nom]->ajouterBesoin($typeBesoin);
                }
            }
        }

        // Traiter les salariés et leurs compétences
        if (isset($data["salaries"])) {
            foreach ($data["salaries"] as $salarieData) {
                $nom = trim($salarieData["nom"]);
                if (!isset($salaries[$nom])) {
                    $salaries[$nom] = new Salarie($nom);
                }

                foreach ($salarieData["competences"] as $competence) {
                    $typeCompetence = $competence["type"];
                    $interet = isset($competence["interet"]) ? intval($competence["interet"]) : 0;
                    $salaries[$nom]->ajouterCompetence($typeCompetence, $interet);
                }
            }
        }

        return ["clients" => array_values($clients), "salaries" => array_values($salaries)];
    }


    public static function lireCsv(string $fichier): array {
        $clients = [];
        $salaries = [];
        $section = "";

        if (($handle = fopen($fichier, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ";")) !== FALSE) {
                // Ignorer les lignes vides
                if (empty(array_filter($row))) {
                    continue;
                }

                if (str_contains($row[0], "besoins")) {
                    $section = "besoins";
                    continue;
                } elseif (str_contains($row[0], "competences")) {
                    $section = "competences";
                    continue;
                }

                // Traiter les besoins (Clients)
                if ($section === "besoins") {
                    $id = $row[0];
                    $nom = $row[1];
                    $typeBesoin = $row[2];

                    if (!isset($clients[$nom])) {
                        $clients[$nom] = new Client($nom);
                    }
                    $clients[$nom]->ajouterBesoin($typeBesoin);
                }

                // Traiter les competences (Salaries)
                if ($section === "competences") {
                    $id = $row[0];
                    $nom = $row[1];
                    $typeCompetence = $row[2];
                    $interet = isset($row[3]) ? intval($row[3]) : 0;

                    if (!isset($salaries[$nom])) {
                        $salaries[$nom] = new Salarie($nom);
                    }
                    $salaries[$nom]->ajouterCompetence($typeCompetence, $interet);
                }
            }
            fclose($handle);
        }

        return ["clients" => array_values($clients), "salaries" => array_values($salaries)];
    }
}