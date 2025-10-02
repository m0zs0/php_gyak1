<?php
/*
CRUD: Create Read Update Delete
tfh: van egy cards táblám, amiben van name, email, id mező.
backtick `
1. MySQL
-READ: SELECT name, email FROM cards WHERE id=10;
-CREATE: INSERT INTO cards (`name`, `email`) VALUES ('Tibi','tibi@mzsrk.hu');
-UPDATE: UPDATE cards SET email='tibi2025@mzsrk.hu' WHERE id = 10;
-DELETE: DELETE FROM cards WHERE id=10;


CREATE DATABASE businesscards;

use businesscards;

CREATE table cards (
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `companyName`  VARCHAR(100) DEFAULT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `status` VARCHAR(10) DEFAULT NULL,
    `note` TEXT DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
*/

// Data Source Name
$dsn = 'mysql:host=localhost;dbname=businesscards;charset=utf8';
$user = 'root';
$pass = '';

try{
    $pdo =new PDO($dsn, $user, $pass);

    // Hiba mód: Exception dobása hiba esetén
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Sikeres csatlakozás!";

    //xss: védekezés: htmlspecialcars()
    //xss($pdo);
    //sql_injection
    //sql_injection($pdo);
    prepared_statement($pdo); // védekezés sql injection ellen

} catch (PDOException $ex){
    echo "Kapcsolódási hiba: {$ex->getMessage()}.";
    exit();
}

function xss($pdo){

    // INSERT
    $name="mozso hack";
    $companyName=htmlspecialchars("<script>alert(\"hacked\")</script>");
    $phone="1234567";
    $email="mozso@mzsrk.hu";
    $photo=null;
    //$status=?
    $note="webfejlesztő";
    $sql = "INSERT INTO cards (`name`, `companyName`, `phone`, `email`, `photo`, `note`)
            VALUES ('$name', '$companyName', '$phone', '$email', '$photo', '$note')";

    $pdo->exec($sql);
    
    // READ
    $sql = "SELECT * FROM cards WHERE name = 'mozso hack'";
    $result = $pdo->query($sql);
    $card = $result->fetch(PDO::FETCH_ASSOC);
    echo "<br>";
    print_r($card);
}

function sql_injection($pdo){
    $name_i="' OR '1' = '1"; // támadó kód
    $sql = "SELECT * FROM cards WHERE name = '$name_i'";
    $result = $pdo->query($sql);
    $card = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "<br>";
    print_r($card);
} 

function prepared_statement($pdo){
    $name_i="' OR '1' = '1"; // támadó kód
    $sql = "SELECT * FROM cards WHERE name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt ->execute([$name_i]);

    $card = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<br>";
    print_r($card);
}
    /*$sql = "INSERT INTO cards (`name`, `companyName`, `phone`, `email`, `photo`, `note`)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt ->execute([$name, $companyName, $phone, $email, $photo, $note]);

    // READ
    /*$sql = "SELECT * FROM cards WHERE id = 12";

    $result = $pdo->query($sql);

    $card = $result->fetch(PDO::FETCH_ASSOC);
    
    echo "<br>";
    print_r($card);

    $sql = "SELECT * FROM cards WHERE id = 12";

    $stmt = $pdo->prepare($sql);
    
    $result = $pdo->query($sql);

    $card = $result->fetch(PDO::FETCH_ASSOC);
    
    echo "<br>";
    print_r($card);


}*/
?>