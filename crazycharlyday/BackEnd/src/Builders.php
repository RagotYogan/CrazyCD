<?php
require_once "Affectation.php";

class Builders
{
    public static function csvBuilder(int $score , array $affectations, string $filename): void {
        $file = fopen($filename, "w");

        // Ajouter l'en-tête du fichier CSV
        fputcsv($file, ["{$score};"]);

        // Ajouter chaque ligne d'affectation
        $i = 0;
        foreach ($affectations as $affectation) {
            $ligne = "$i;{$affectation[0]->nom};{$affectation[1]};{$affectation[2]->nom}";
            fwrite($file, $ligne . PHP_EOL); // Écrit la ligne directement dans le fichier
            $i++;
        }

        fclose($file);
        echo "\nExportation réussie : $filename\n";
    }



    public static function jsonBuilder(int $score, array $affectations, string $filename): void {
        $data = [
            "score" => $score,
            "affectations" => []
        ];

        // Ajouter les affectations sous forme de tableau associatif
        foreach ($affectations as $affectation) {
            $data["affectations"][] = [
                "salarie" => $affectation[0]->nom,
                "besoin" => $affectation[1],
                "client" => $affectation[2]->nom
            ];
        }

        // Convertir en JSON avec indentation pour une meilleure lisibilité
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Écrire dans le fichier
        if (file_put_contents($filename, $json) === false) {
            throw new Exception("Erreur lors de l'écriture du fichier JSON.");
        }

        echo "Exportation réussie : $filename\n";
    }


}