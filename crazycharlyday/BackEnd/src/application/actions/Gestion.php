<?php

namespace BackEnd\application\actions;

use BackEnd\infrastructure\ConnexionFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Gestion
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $pdo = ConnexionFactory::makeConnection();
        $method = $rq->getMethod();

        if ($method === 'OPTIONS') {
            return $rs->withStatus(200);
        }


        if ($method === 'GET') {
            // Récupérer toutes les compétences
            $statement = $pdo->prepare("SELECT * FROM competences");
            $statement->execute();
            $competences = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $rs->getBody()->write(json_encode($competences));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        }

        if ($method === 'POST') {
            // Ajouter une nouvelle compétence
            $data = json_decode($rq->getBody()->getContents(), true);
            if (!isset($data['nom'])) {
                return $rs->withHeader('Content-Type', 'application/json')->withStatus(400)
                    ->write(json_encode(['error' => 'Nom requis']));
            }

            $statement = $pdo->prepare("INSERT INTO competences (nom) VALUES (?)");
            $statement->execute([$data['nom']]);

            $rs->getBody()->write(json_encode(['message' => 'Compétence ajoutée avec succès']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);
        }

        return $rs->withStatus(405);
    }
}
?>