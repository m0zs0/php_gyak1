<?php
// --- Fájl: index.php (főkönyvtár) ---
// Ez az MVC alkalmazás "Controller" része.

// Egyszerű autoloader a kód betöltéséhez
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\BusinessCard;
use App\Services\CardManager;
//use PDO;
//use PDOException;

// Adatbázis konfiguráció (valós projektben .env fájlban lenne)
$dbHost = 'localhost';
$dbName = 'business_db';
$dbUser = 'root';
$dbPass = '';

$pdo = null;
try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Adatbázis-kapcsolat sikeressége
} catch (PDOException $e) {
    die("Hiba az adatbázis-kapcsolatban: " . $e->getMessage());
}

// Létrehozzuk a "business_cards" táblát, ha még nem létezik.
$sql = "
    CREATE TABLE IF NOT EXISTS business_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NOT NULL,
        company VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;
";
$pdo->exec($sql);

$manager = new CardManager($pdo);

// A kérések feldolgozása (routing)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // Új névjegy hozzáadása űrlapból
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['company'])) {
            $card = new BusinessCard(
                null,
                $_POST['name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['company']
            );
            $manager->addCard($card);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        // Névjegy szerkesztése űrlapból
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = (int)$_POST['id'];
            $data = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'phone' => $_POST['phone'] ?? null,
                'company' => $_POST['company'] ?? null,
            ];

            // Töröljük a null értékeket, hogy a CardManager csak a módosított mezőket frissítse.
            $data = array_filter($data, function($value) {
                return $value !== null;
            });
            
            $manager->editCard($id, $data);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Névjegy törlése
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $manager->deleteCard((int)$_POST['id']);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    }
}

// Adat lekérése a listázáshoz a HTML-ben
$cards = $manager->listCards();

// Megjelenítő fájl behívása
require_once 'App\Views\index.view.php';