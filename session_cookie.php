<?php

// Session indítás

session_start();

// SESSION
if (isset($_POST['session_name']) && !empty($_POST['session_name'])) {
    $_SESSION['name'] = $_POST['session_name'];
    echo "Sikeresen beállítottad a sessiont: ".$_SESSION['name']."<br>";
}

// Cookie beállítás
$cookie_name = "user_name";
$cookie_value = "Tibi";
$cookie_time = time() + (86400 * 30); // 30 napig tárolja
if (isset($_POST['cookie_value']) && !empty($_POST['cookie_value'])) {
    
    setcookie($cookie_name, $_POST['cookie_value'], $cookie_time, "/");
    echo "Sikeresen beállítottad a cookie-t: ".$_COOKIE['user_name']."<br>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session_cookie</title>
</head>
<body>
    <h2>Session</h2>
    <form action="" method="post">
        <label for="session_name">Add meg a neved a session-höz</label>
        <input type="text" name="session_name" id="session_name">
        <button type="submit">Session beállítása</button>
    </form>

    <?php
        if (isset($_SESSION['name'])) {
            echo "<p>A session neve: <strong> {$_SESSION['name']} </strong></p>";
        }
        else {
            echo "Nincs session adat beállítva<br>";
        }
    ?>

    <form action="" method="post">
        <label for="cookie_value">Add meg a neved a cookie-hoz</label>
        <input type="text" name="cookie_value" id="cookie_value">
        <button type="submit">Cookie beállítása</button>
    </form>

    <?php
        if (isset($_COOKIE[$cookie_name])) {
            echo "<p>A cookie neve: <strong> {$_COOKIE[$cookie_name]} </strong></p>";
        }
        else {
            echo "Nincs cookie beállítva<br>";
        }
    ?>

    <a href="?torles">Session és süti törlése</a>
    <br>

    <?php
        if (isset($_GET['torles'])) {
            //session törlése
            session_unset(); // Session változók törlése
            session_destroy(); // session törlése

            // cookie törlése
            setcookie($cookie_name, "", time() - 3600);
            echo "Session és süti törlése megtörtént.<br>";
        }
    ?>
</body>
</html>