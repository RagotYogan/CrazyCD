<?php

namespace BackEnd\application\actions;

use BackEnd\infrastructure\CompetenceRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Gestion
{
    private CompetenceRepository $competenceRepository;

    public function __construct(CompetenceRepository $competenceRepository)
    {
        $this->competenceRepository = $competenceRepository;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $method = $rq->getMethod();

        if ($method === 'OPTIONS') {
            return $rs->withStatus(200);
        }

        if ($method === 'GET') {
            // Récupérer toutes les compétences
            $competences = $this->competenceRepository->getAll();
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

            $this->competenceRepository->save($data);

            $rs->getBody()->write(json_encode(['message' => 'Compétence ajoutée avec succès']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);
        }

        return $rs->withStatus(405);
    }
}
?>