<?php
// Belépési pont
// Controller: végpontokat kezel

// Egyszerű autoloader a kód betöltéséhez a mappaszerkezet alapján.
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\BusinessCard;
use App\Services\CardManager;
//use PDO;

//Adatbázis konfig (.env)
$dbHost = 'localhost';
$dbName = 'business_db';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Sikeres adatbázis-kapcsolat.\n";
} catch (PDOException $ex) {
    die("Hiba az adatbázis-kapcsolatban: ". $ex->getMessage());
}

$sql = "
    CREATE TABLE IF NOT EXISTS business_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NOT NULL,
        company VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = InnoDB;
";

$pdo->exec($sql);

$manager = new CardManager($pdo);

$action = $argv[1] ?? 'list';

switch ($action){
    case 'list':
        echo '--- Névjegyek listája ---';
        $manager->listCards();
        break;
    case 'add':
        $data = [
            'name' => $argv[2] ?? 'Kiss Pista',
            'email' => $argv[3] ?? 'kisspista@mzsrk.hu',
            'phone' => $argv[4] ?? '+361234123',
            'company' => $argv[5] ?? 'Móricz Bt.',
        ];

        $card = new BusinessCard(null, $data['name'],$data['email'],$data['phone'],$data['company']);
        $manager->addCard($card);
        break;
    case 'edit':
        $id = $argv[2] ?? 1;
        $data = [];

        // Kulcs értékpárok feldolgozásának kezdete
        //pl: php index.php edit 1 --name="mozso" --email="mozos@mzsrk.hu"
        for ($i=3; $i< count($argv);$i++){
            $arg = $argv[$i];
            if (strpos($arg, '--') == 0) {
                $parts = explode('=', substr($arg, 2), 2);
                if (count($parts) == 2){
                    $key = $parts[0];
                    $value = $parts[1];
                    $data[$key] = $value;
                }
            }
        }

        $manager->editCard($id, $data);
        break;
    default:
        echo 'Ismeretlen parancs. Használat: php index.php [list|add|edit|delete]\n';
        break;
}
?>