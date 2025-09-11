<?php
/*
    fgv definiálása, paraméterek, visszatérésiérték
*/

//Írj egy fgv-t, ami visszaadja két szám összegét
function sum(int $a, int $b): int{
    return $a + $b;
}

$s1 = sum(5,3);
echo "{$s1} <br>";
$s2 = sum("4","6" );
echo "$s2 <br>";

function sayHello($name="Guest"){
    return "Hello $name!";
}

echo sayHello("mozso");
?>