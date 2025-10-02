<?php
require_once 'connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $feltoltve_mappa = "uploads/";
        $name= htmlspecialchars(ucwords(strtolower(trim($_POST['name']))));
        $companyName = htmlspecialchars(trim($_POST['companyName']));
        $phone = $_POST['phone'];
        $email = htmlspecialchars(strtolower(trim($_POST['email'])));   
        $note = htmlspecialchars($_POST['note']);

        
        // Fájlfeltöltés kezelése
        if (empty($_FILES['photo']['name'])) {
            throw new Exception("Kérem, válasszon egy fotót.");
        }

        $fajlnev = basename($_FILES["photo"]["name"]);
        $ideiglenes_fajlnev = $_FILES["photo"]["tmp_name"];
        $hiba = $_FILES["photo"]["error"];
        $fajl_meret = $_FILES["photo"]["size"];
        $fajl_tipus = strtolower(pathinfo($fajlnev, PATHINFO_EXTENSION));
        $cel_fajl = $feltoltve_mappa . $fajlnev;

        if ($hiba !== 0) {
            throw new Exception("Hiba történt a fájl feltöltése során. Hiba kód: {$hiba}");
        }
        if (!is_writable($feltoltve_mappa)) {
            throw new Exception("A feltöltési mappa nem írható.");
        }
        if (file_exists($cel_fajl)) {
            throw new Exception("Sajnálom, de a fájl már létezik.");
        }
        if ($fajl_meret > 5000000) { // Max 5 MB
            throw new Exception("A fájl mérete túl nagy.");
        }
        if (!in_array($fajl_tipus, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek.");
        }

        if (!move_uploaded_file($ideiglenes_fajlnev, $cel_fajl)) {
            throw new Exception("Hiba történt a fájl áthelyezése során.");
        }

        // Adatbázisba szúrás
        $sql = "INSERT INTO Cards (`name`, `companyName`, `phone`, `email`, `photo`, `note`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        $params = [
            $_POST['name'],
            $_POST['companyName'],
            $_POST['phone'],
            $_POST['email'],
            $fajlnev,
            $_POST['note']
        ];
        $stmt->execute($params);
        header("Location: list.php");
        exit();

    } catch (Exception $e) {
        $error = "Hiba történt: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Új névjegy hozzáadása</title>
    <style>
        body { font-family: sans-serif; }
        .center-container { display: flex; justify-content: center; }
        form {background-color: white; padding: 20px 30px; border: 2px solid #ccc;  border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); max-width: 400px; }
        label {display: block; margin-bottom: 10px; font-weight: bold; width: 100px; }
        input { padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; width: 100%; box-sizing: border-box;}
        textarea { height: 50px; width: 100%; resize: vertical; }
        .submit-container { text-align: center; }
        .submit-btn { padding: 8px 16px; border: 1px solid #ddd;  border-radius: 4px; background-color: #f5f5f5; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease; width: 100px; }
        .submit-btn:hover { background-color: #e0e0e0;}

        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="center-container">
        

        <form action="" method="post" enctype="multipart/form-data">
            <h1>Új névjegy hozzáadása</h1>
        
            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <label for="name">Név:</label>
            <input type="text" id="name" name="name" value="<?php if (isset($name)) print $name; ?>" required><br>
            <label for="companyName">Cégnév:</label>
            <input type="text" id="companyName" name="companyName" value="<?php if (isset($companyName)) print $companyName; ?>" required><br>
            <label for="phone">Telefon:</label>
            <input type="tel" id="phone" name="phone" value="<?php if (isset($phone)) print $phone; ?>" required><br>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php if (isset($email)) print $email; ?>" required><br>
            <label for="photo">Fotó:</label>
            <input type="file" id="photo" name="photo" required><br>
            <label for="note">Megjegyzés:</label>
            <textarea id="note" name="note" rows="4"><?php if (isset($note)) print $note; ?></textarea><br>
            <p class="submit-container">
                <input type="submit" value="Add Card" class="submit-btn">
                <input type="reset" value="Reset" class="submit-btn">
                <button type="button" onclick="window.location.href='list.php'" class="submit-btn">Cancel</button>
            </p>
        </form>
    </div>
</body>
</html>