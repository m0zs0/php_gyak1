<?php

namespace App\Services;
use App\Models\BusinessCard;
use PDO;
use PDOException;
class CardManager
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function addCard(BusinessCard $card): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO business_cards (name, email, phone, company) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $card->name,
            $card->getEmail(),
            $card->getPhone(),
            $card->company
        ]);
    }
    public function listCards(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM business_cards ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function editCard(int $id, array $data): void
    {
        if (empty($data)) {
            return;
        }
        $setClause = [];
        $params = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $sql = "UPDATE business_cards SET " . implode(', ', $setClause) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
    public function deleteCard(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM business_cards WHERE id = ?");
        $stmt->execute([$id]);
    }
}