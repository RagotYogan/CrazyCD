<?php

namespace BackEnd\infrastructure;


use PDO;

class BesoinsRepository
{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function save($data): void
    {
        $stmt = $this->db->prepare("INSERT INTO besoins (client, libelle, competence) VALUES (:client, :libelle, :competence)");
        $stmt->bindParam(':client', $data['client']);
        $stmt->bindParam(':libelle', $data['libelle']);
        $stmt->bindParam(':competence', $data['competence']);
        $stmt->execute();
    }
}