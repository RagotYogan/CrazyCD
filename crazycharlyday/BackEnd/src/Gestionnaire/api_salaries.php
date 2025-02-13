<?php
include 'connexionFactory.php';
$pdo = connexionFactory::makeConnection();

header('Content-Type: application/json');

$request_method = $_SERVER["REQUEST_METHOD"];


switch ($request_method) {
    case 'GET':
        // Récupérer tous les salariés
        $statement = $pdo->prepare("SELECT * FROM salaries");
        $statement->execute();
        $salaries = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($salaries);
        break;

    case 'POST':
        // Ajouter un nouveau salarié
        $data = json_decode(file_get_contents('php://input'), true);
        $nom = $data['nom'];
        $statement = $pdo->prepare("INSERT INTO salaries (nom) VALUES (?)");
        $statement->execute([$nom]);
        echo json_encode(['message' => 'Salarié ajouté avec succès']);
        break;

    // Ajoutez d'autres cas pour PUT et DELETE si nécessaire

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
