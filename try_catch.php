<?php
    $dataFile = "data.txt";
    $logFile = "log.txt"; 
    $message = "";
    $error = "";

    try{
        if (file_exists($dataFile)) {
            $currentContent = file_get_contents($dataFile);
        } else {
            throw new Exception("A $dataFile fájl nem található!");
        }

        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['new_content'])) {
            $new_content = $_POST['new_content'];

            if (file_put_contents($dataFile, $new_content) != false) {
                $message = "Sikeresen módosult a $dataFile fájl!";
                $currentContent = $new_content;
                // Naplózás
                $currentTime = date('Y-m-d H:i:s');
                $logEntry = "[{$currentTime}] Módosítás: A(z) '{$dataFile}' fájl tartalma módosítva lett.\n";
                if (file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX) == false) {
                    throw new Exception("Nem sikerült a naplózás a {$logFile}-ba!");
                }

            } else {
                throw new Exception("A $dataFile írása sikertelen!");
            }
        }

    } catch (Exception $ex){
        $error = "Hiba: ". $ex->getMessage();
    }
     
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try catch</title>
</head>
<body>
    <h2>Fájlkezelés</h2>
    <?php if (isset($error) && !empty($error))?>
    <p><?= $error?></p>
    <?php if (isset($message) && !empty($message))?>
    <p><?= $message?></p>
    
    <h2>A data.txt tartalma:</h2>
    
    <pre><?= htmlspecialchars($currentContent)?></pre>

    <h2>Módosítás</h2>
    <form action="" method="post">
        <label for="new_content">Új tartalom</label>
        <textarea name="new_content" id="new_content"><?= htmlspecialchars($currentContent)?></textarea>
        <button type="submit">Mentés</button>
    </form>
</body>
</html>