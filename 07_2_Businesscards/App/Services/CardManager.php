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

        public function listcards(): void{

            $stmt = $this->pdo->query("SELECT * FROM business_cards ORDER BY id");
            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "--- Névjegyek listája (".count($cards).") --- \n";
            foreach ($cards as $cardData){
                $card = new BusinessCard($cardData['id'],$cardData['name'],$cardData['email'], $cardData['phone'],$cardData['company']);
                echo "ID: {$cardData['id']} |". $card->displayCard()."\n"; 
            }

            echo "-------------------------------------\n";
        }
    }
?>