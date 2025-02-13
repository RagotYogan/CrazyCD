<?php

namespace BackEnd\core\services;

use BackEnd\infrastructure\SalariesRepository;

class ServiceSalaries
{
    private SalariesRepository $salariesRepository;

    public function __construct(SalariesRepository $salariesRepository){
        $this->salariesRepository = $salariesRepository;
    }

    public function getSalaries(): array
    {
        return $this->salariesRepository->getAll();
    }

    public function createSalarie($data): void
    {
        $this->salariesRepository->save($data);
    }
}