<?php
if (isset($_COOKIE['counter'])) {
    $counter = $_COOKIE['counter'] + 1;
}
else
{
    $counter = 1;
}
setcookie('counter', $counter,time() + 86400 );
echo "Az megnyitások száma $counter";

?>