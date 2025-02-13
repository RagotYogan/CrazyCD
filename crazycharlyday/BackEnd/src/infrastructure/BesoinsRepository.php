<?php

namespace BackEnd\infrastructure;


use PDO;
use PDOException;

class BesoinsRepository
{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function save($data): void
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO besoins (client, libelle, competence) VALUES (:client, :libelle, :competence)");
            $stmt->bindParam(':client', $data['client']);
            $stmt->bindParam(':libelle', $data['libelle']);
            $stmt->bindParam(':competence', $data['competence']);
            $stmt->execute();
        }catch (PDOException $e) {
            throw new \Exception('Error while saving besoin: '. $e->getMessage());
        }

    }

    public function getBesoinsByClient($client): array
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM besoins WHERE client = :client");
            $stmt->bindParam(':client', $client);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            throw new \Exception('Error while getting besoins by client: '. $e->getMessage());
        }

    }

    public function updateBesoin($id, $data): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE besoins SET libelle = :libelle, competence = :competence WHERE id_besoins = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':libelle', $data['libelle']);
            $stmt->bindParam(':competence', $data['competence']);
            $stmt->execute();
        }catch (PDOException $e) {
            throw new \Exception('Error while updating besoin: '. $e->getMessage());
        }

    }
}