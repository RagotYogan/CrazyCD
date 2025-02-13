<?php
require_once "Affectation.php";

class Builders
{
    public static function CsvBuilder(int $score , array $affectations, string $filename): void {
        echo "\n";
        echo $score;
        echo "\n";
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



    public static function BaseBuilder (array $affectation): void {
        // cree un csv a partir de l'affectation
    }
}