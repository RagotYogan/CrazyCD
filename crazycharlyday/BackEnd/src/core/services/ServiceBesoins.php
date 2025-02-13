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
        try {
            $this->besoinsRepository->save($data);
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de la creation d\'un besoin: '. $e->getMessage());

        }
    }

    public function getBesoinsByClient($client): array
    {
        try {
            return $this->besoinsRepository->getBesoinsByClient($client);
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de la recupération des besoins: '. $e->getMessage());
        }
    }

    public function updateBesoin($id, $data): void
    {
        try {
            $this->besoinsRepository->updateBesoin($id, $data);
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de la mise à jour du besoin: '. $e->getMessage());
        }
    }
}