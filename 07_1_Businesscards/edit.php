<?php
require_once 'connection.php';

$error = '';
$card = [];

// === Lekérdezzük a szerkesztendő névjegyet GET paraméter alapján ===
if (isset($_GET['id'])) {
    try {
        $id = (int)$_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM Cards WHERE id = ?");
        $stmt->execute([$id]);
        $card = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$card) {
            throw new Exception("A szerkesztendő névjegy nem található.");
        }
    } catch (Exception $e) {
        $error = "Hiba: " . $e->getMessage();
    }
}

// === POST kérés kezelése: A módosítások mentése ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id = (int)$_POST['id'];
        $name = htmlspecialchars(ucwords(strtolower(trim($_POST['name']))));
        $companyName = htmlspecialchars(trim($_POST['companyName']));
        $phone = $_POST['phone'];
        $email = htmlspecialchars(strtolower(trim($_POST['email'])));
        $note = htmlspecialchars($_POST['note']);
        $photoName = $_POST['existing_photo'];

        $feltoltve_mappa = "uploads/";

        // Fájlfeltöltés kezelése, ha a felhasználó új képet tölt fel
        if (!empty($_FILES['photo']['name'])) {
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
            if (file_exists($cel_fajl) && $fajlnev !== $photoName) {
                throw new Exception("Sajnálom, de ez a fájlnév már létezik.");
            }
            if ($fajl_meret > 5000000) {
                throw new Exception("A fájl mérete túl nagy.");
            }
            if (!in_array($fajl_tipus, ["jpg", "jpeg", "png", "gif"])) {
                throw new Exception("Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek.");
            }

            if (move_uploaded_file($ideiglenes_fajlnev, $cel_fajl)) {
                // Töröljük a régi képet, ha létezik és nem azonos az újjal
                if (!empty($photoName) && $photoName !== $fajlnev && file_exists($feltoltve_mappa . $photoName)) {
                    unlink($feltoltve_mappa . $photoName);
                }
                $photoName = $fajlnev;
            } else {
                throw new Exception("Hiba történt a fájl áthelyezése során.");
            }
        }

        // Adatbázis módosítása
        $sql = "UPDATE Cards SET `name` = ?, `companyName` = ?, `phone` = ?, `email` = ?, `photo` = ?, `note` = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        $params = [
            $name,
            $companyName,
            $phone,
            $email,
            $photoName,
            $note,
            $id
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
    <title>Névjegy szerkesztése</title>
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
            <h1>Névjegy szerkesztése</h1>

            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <?php if ($card): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($card['id']) ?>">
                <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($card['photo']) ?>">

                <label for="name">Név:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($card['name']) ?>" required><br>

                <label for="companyName">Cégnév:</label>
                <input type="text" id="companyName" name="companyName" value="<?= htmlspecialchars($card['companyName']) ?>" required><br>

                <label for="phone">Telefon:</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($card['phone']) ?>" required><br>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($card['email']) ?>" required><br>

                <label for="photo">Fotó:</label>
                <input type="file" id="photo" name="photo"><br>
                <p>Jelenlegi kép: <img src="uploads/<?= htmlspecialchars($card['photo']) ?>" style="max-width: 100px;"></p>

                <label for="note">Megjegyzés:</label>
                <textarea id="note" name="note" rows="4"><?= htmlspecialchars($card['note']) ?></textarea><br>

                <p class="submit-container">
                    <input type="submit" value="Update Card" class="submit-btn">
                    <button type="button" onclick="window.location.href='list.php'" class="submit-btn">Cancel</button>
                </p>
            <?php else: ?>
                <p class="error">A keresett névjegy nem található.</p>
                <button type="button" onclick="window.location.href='list.php'" class="submit-btn">Vissza</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>