<?php
require_once "Salarie.php";
require_once "Client.php";
require_once "Affectation.php";
require_once "Readers.php";



// Lire les données du CSV
$data = Readers::lireCsv("../DataTest/metier_2.csv");

// Récupérer les objets Clients et Salariés
$clients = $data["clients"];
$salaries = $data["salaries"];

(new Affectation)->affecter($salaries,$clients);

