<?php
    namespace App\Services;

    use App\Models\BusinessCard;
    use PDO;

    class CardManager{
        private PDO $pdo;

        public function __construct(PDO $pdo){
            $this->pdo= $pdo;
        }

        public function addCard(BusinessCard $card): void{
            $stmt = $this->pdo->prepare("
                INSERT INTO business_cards (name, email, phone, company)
                VALUES (?,?,?,?)");
            $stmt->execute([$card->name, 
                            $card->getEmail(), 
                            $card->getPhone(), 
                            $card->company]);
            echo "Névjegy sikeresen hozzáadva!";
        }
    }
?>