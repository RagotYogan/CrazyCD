<?php

namespace BackEnd\core\services;


use BackEnd\infrastructure\BesoinsRepository;

class ServiceBesoins
{
    private BesoinsRepository $besoinsRepository;

    public function __construct(BesoinsRepository $besoinsRepository){
        $this->besoinsRepository = $besoinsRepository;
    }

    public function createBesoins($data): void
    {
        $this->besoinsRepository->save($data);
    }

    public function getBesoinsByClient($client): array
    {
        return $this->besoinsRepository->getBesoinsByClient($client);
    }
}