<?php
require_once 'connection.php';

// === TÖRÖLÉS MŰVELET GET-tel ===
if (isset($_GET['delete'])) {
    try {
        $id = (int)$_GET['delete'];
        
        // Először töröljük a képet a szerverről
        $stmt_photo = $pdo->prepare("SELECT photo FROM Cards WHERE id = ?");
        $stmt_photo->execute([$id]);
        $card = $stmt_photo->fetch(PDO::FETCH_ASSOC);

        if ($card && !empty($card['photo'])) {
            $photoPath = 'uploads/' . $card['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath); // Törli a fájlt
            }
        }
        
        // Majd töröljük a rekordot az adatbázisból
        $stmt_delete = $pdo->prepare("DELETE FROM Cards WHERE id = ?");
        $stmt_delete->execute([$id]);

        header("Location: list.php");
        exit();

    } catch (PDOException $e) {
        $error = "Hiba történt a törlés során: " . $e->getMessage();
    }
}

// === NÉVJEGYEK LISTÁZÁSA ===
$stmt = $pdo->query("SELECT * FROM Cards ORDER BY id DESC");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Névjegyek</title>
    <!-- Font Awesome betöltése CDN-ről -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        tr:nth-child(even) { background-color: #f9f9f9;}
        tr:nth-child(odd) { background-color: #cacaca;}
        th, td { padding: 10px; border: 1px solid #999; text-align: left; }
        th { background-color: #000; color: #fff}
        img { max-width: 80px; height: auto; }
        .actions-cell { text-align: center; vertical-align: middle;}
        .actions-cell a { color: #007bff; }
        .actions-cell a:hover { color:aqua }
        .actions-container { display: inline-flex; align-items: center;  gap: 20px; vertical-align: middle; }
    </style>
</head>
<body>
    <h1>Névjegyek listája</h1>
    
    <?php if (empty($cards)){?>
        <p>Nincs még névjegy a listában.</p>
    <?php }else{ ?>
        <table>
            <thead>
                <tr>
                    <th>Fotó</th>
                    <th>Név</th>
                    <th>Cég</th>
                    <th>Telefon</th>
                    <th>E-mail</th>
                    <th>Megjegyzés</th>
                    <th class="actions-cell"><a href="add.php"><i class="fa-solid fa-plus"></i></a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $card){ ?>
                    <tr>
                        <td><img src="uploads/<?= htmlspecialchars($card['photo']) ?>" alt="<?= htmlspecialchars($card['name']) ?>"></td>
                        <td><?= htmlspecialchars($card['name']) ?></td>
                        <td><?= htmlspecialchars($card['companyName']) ?></td>
                        <td><?= htmlspecialchars($card['phone']) ?></td>
                        <td><?= htmlspecialchars($card['email']) ?></td>
                        <td><?= htmlspecialchars($card['note']) ?></td>
                        <td class="actions-cell">
                            <div class="actions-container">
                                <a href="?delete=<?=$card['id'];?>" onclick="return confirm('Biztosan törlöd?');"><i class="fa-solid fa-trash"></i></a>
                                <a href="edit.php?id=<?=$card['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</body>
</html>