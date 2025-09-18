<?php

//["kulcs"=>"érték", "kulcs2"=>"érték2",... ]
// PHP tömb
$termekek = [
    [
        "id"=>1,
        "nev"=>"monitor",
        "ar"=>100000,
        "keszleten"=>true
    ],
    [
        "id"=>2,
        "nev"=>"billentyűzet",
        "ar"=>10000,
        "keszleten"=>false
    ]
];

foreach ($termekek as $termek) {
    echo "{$termek['id']}, {$termek['nev']}, {$termek['ar']}, {$termek['keszleten']}<br>";
}

//PHP tömb konvertálása json-né
$json_termekek = json_encode($termekek, JSON_PRETTY_PRINT); //JSON_PRETTY_PRINT csak fejlesztéskor

echo "<h2>JSON formátum</h2>";
echo "<pre>".$json_termekek."</pre>";

$dekodolt_termekek = json_decode($json_termekek, true);

foreach($dekodolt_termekek as $termek){
    echo "{$termek['id']}, {$termek['nev']}, {$termek['ar']}, {$termek['keszleten']}<br>";
}
?>