<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERVER szuperglobális</title>
</head>
<body>
    <h2>SERVER tömb információi</h2>
    <ul>
        <li>
            <strong>Kérés módja: </strong>
            <?php echo "{$_SERVER['REQUEST_METHOD']}"; ?>
        </li>
        <li>
            <strong>Kért URL: </strong>
            <?php echo "{$_SERVER['REQUEST_URI']}"; ?>
        </li>
        <li>
            <strong>Szkript neve: </strong>
            <?php echo "{$_SERVER['PHP_SELF']}"; ?>
        </li>
        <li>
            <strong>Query string: </strong>
            <?php echo empty($_SERVER['QUERY_STRING'])? "Nincs":$_SERVER['QUERY_STRING']; ?>
        </li>
    </ul>

    <?php // Feladat: írasd ki egymás alá a kapott kulcs értékpárokat, ne a $_GET-et használd 
    
    /*paraméterek:
    Ha van QUERY_STRING:
    <ul>
        <li>name=mozso</li>
        <li>age=22</li>
    </ul>*/
    ?>



    <h3>Szerver adatai</h3>
    <ul>

    </ul>
    // Szerver neve: SERVER_NAME
    // Szerver IP címe: SERVER_ADDR

    <h3>Felahsználó adatai</h3>
    // Böngésző adatai: HTTP_USER_AGENT
    // Felhasználó IP címe: REMOTE_ADDR

    <p>
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?name=mozso&age=22">Kattints ide egy paraméterezett GET kéréshez!</a>
    </p>
</body>
</html>