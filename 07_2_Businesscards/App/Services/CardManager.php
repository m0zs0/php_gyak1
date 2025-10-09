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

        public function editCard(int $id, array $data): void{
            if (empty($data)){
                echo "Figyelmeztetés: Nincs frissítendó adat megadva.\n";
                return;
            }

            $setClause = [];
            $params = [];

            foreach ($data as $key => $value) {
                $setClause[] = "{$key} = ?";
                $params[] = $value;
            }

            $params[] = $id;

            $sql = "UPDATE business_cards SET ".implode(', ', $setClause) ." WHERE id = ?";

            $stmt = $this->pdo->prepare($sql);

            $success = $stmt->execute($params);

            if ($success) {
                echo "A(z) {$id} id-jű névjegy sikeresen frissítve.\n";
            } else {
                echo "Hiba: A névjegy frissítése sikertelen volt.\n";
            }

        }
        public function deleteCard(int $id): void{
            if (empty($id)){
                echo "Figyelmeztetés: Nincs törlendő id megadva.\n";
                return;
            }

            $sql = "DELETE FROM business_cards WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);

            $success = $stmt->execute([$id]);
            
            if ($success && $stmt->rowCount()>0) {
                echo "A(z) {$id} id-jű névjegy sikeresen törölve.\n";
            } else {
                echo "Hiba: A névjegy törlése sikertelen volt.\n";
            }
        }

    }
?>