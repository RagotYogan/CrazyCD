<?php

class Readers
{
    public static function BaseReader(string $nomDefaut): array {
        return ["Exemple" => 10]; // Placeholder pour une vraie requête BD
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