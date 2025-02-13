<?php

namespace BackEnd\infrastructure;

use PDO;

class SalariesRepository
{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM salarie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($data): void
    {
        $stmt = $this->db->prepare("INSERT INTO salarie (nom, competence) VALUES (:nom, :competence)");
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':competence', $data['competence']);
        $stmt->execute();
    }
}