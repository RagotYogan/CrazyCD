<?php

namespace BackEnd\infrastructure;

class CompetenceRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save($data): void
    {
        $stmt = $this->db->prepare("INSERT INTO competences (nom) VALUES (:nom)");
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM competences");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}