<?php

namespace BackEnd\core\services;

use BackEnd\infrastructure\CompetenceRepository;

class ServiceCompetence
{
    private CompetenceRepository $competenceRepository;

    public function __construct(CompetenceRepository $competenceRepository){
        $this->competenceRepository = $competenceRepository;
    }

    public function getCompetences(): array
    {
        return $this->competenceRepository->getAll();
    }

    public function createCompetence($data): void
    {
        $this->competenceRepository->save($data);
    }
}