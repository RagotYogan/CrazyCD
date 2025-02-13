<?php
include 'connexionFactory.php';

$pdo = connexionFactory::makeConnection();

header('Content-Type: application/json');

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Récupérer toutes les compétences
        $statement = $pdo->prepare("SELECT * FROM competences");
        $statement->execute();
        $competences = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($competences);
        break;

    case 'POST':
        // Ajouter une nouvelle compétence
        $data = json_decode(file_get_contents('php://input'), true);
        $nom = $data['nom'];
        $statement = $pdo->prepare("INSERT INTO competences (nom) VALUES (?)");
        $statement->execute([$nom]);
        echo json_encode(['message' => 'Compétence ajoutée avec succès']);
        break;

    // Ajoutez d'autres cas pour PUT et DELETE si nécessaire

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
