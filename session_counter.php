<?php

session_start();


    if (isset($_SESSION['pageload']))
    {
        $_SESSION['pageload']++;
    }
    else
    {
        $_SESSION['pageload'] = 1;
    }

echo "Az oldal betöltve {$_SESSION['pageload']}-szor";

?>