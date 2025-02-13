<?php

namespace BackEnd\core\services;

use BackEnd\infrastructure\OptiRepository;

class ServiceOpti
{
    private OptiRepository $optiRepository;

    public function __construct(OptiRepository $optiRepository){
        $this->optiRepository = $optiRepository;
    }

    public function createOptimisation($filePath): array
    {
        return $this->optiRepository->save($filePath);
    }
}
