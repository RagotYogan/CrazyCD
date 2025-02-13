<?php
require_once "Salarie.php";
require_once "Client.php";
require_once "Affectation.php";
require_once "Readers.php";
require_once "Builders.php";

// Lire les données du CSV
$data = Readers::lireCsv("../DataTest/metier_1.csv");

// Récupérer les objets Clients et Salariés
$clients = $data["clients"];
$salaries = $data["salaries"];


$affect = new Affectation();
$affectation = $affect->affecter($salaries,$clients);
$score = $affect->calculerScore($affectation,$salaries,$clients);


Builders::CsvBuilder($score, $affectation,"../DataTest/test.csv");