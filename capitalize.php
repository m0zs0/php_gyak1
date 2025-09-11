<?php
//Készíts egy függvényt, ami átvesz egy string tömböt és visszaadja nagybetűsként
function capitalizeAll(array $names): array{
    /*$tempArray = [];
    foreach ($names as $name) {
        $tempArray[] = mb_strtoupper($name);
    }
    return $tempArray;*/
    return array_map("mb_strtoupper",$names);
}

$names = ["Pista","Jóska","Éva"];

$capitalizedNames = capitalizeAll($names);

print_r($capitalizedNames);

?>