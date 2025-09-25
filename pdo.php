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
} catch (PDOException $ex){
    echo "Kapcsolódási hiba: {$ex->getMessage()}.";

}
?>