<?php
if (isset($_POST["submit"])){

    try{
        $uploadFolder = "uploads/";

        //alapvető információk
        $fileName = basename($_FILES["kep"]["name"]);
        $tempFileName = $_FILES["kep"]["tmp_name"];
        $fileSize = $_FILES["kep"]["size"];
        $error = $_FILES["kep"]["error"];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $targetFile = $uploadFolder.$fileName;

        // Ellenőrzések

        // 1. Hiba a feltöltött file-val
        if ($error) {
            throw new Exception("Hiba történt a feltöltés során: $error");
        }

        // 2. feltöltési mappa létezése vagy írása
        if (!is_dir($uploadFolder) || !is_writable($uploadFolder)) {
            throw new Exception("A(z) {$uploadFolder} mappa nem létezik vagy nem írható! ");
        }

        // 3. már létezik ilyen fájl
        if (file_exists($targetFile)) {
            throw new Exception("Már létezik a {$targetFile} fájl!");
        }

        // 4. Fájl méretének ellenőrzése
        if ($fileSize > 5000000) {
            throw new Exception("Túl nagy a fájl! Max 5MB!");
        }

        // 5. Fájl típusának ellenőrzése
        if (!in_array($fileType, ["jpg","jpeg","png","gif"])) {
            throw new Exception("Nem megfelelő a fájl típusa [jpg, jpeg, png, gif]!");
        }

        // Fájl áthelyezése temp -> target be
        if (move_uploaded_file($tempFileName, $targetFile)) {
            echo "Sikeresen feltöltve a(z) {$targetFile}.";
        } else {
            throw new Exception("Hiba történt az átmozgatás során!");
        }

    } catch (Exception $ex){
        echo "Hiba történt: {$ex->getMessage()}";
    }


}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fileupload</title>
</head>
<body>
    <h2>Fájl feltöltése</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="kép">Válassz egy képet a feltöltéshez</label>
        <input type="file" name="kep" id="kep">
        <button type="submit" name="submit">Feltöltés</button>

    </form>
</body>
</html>