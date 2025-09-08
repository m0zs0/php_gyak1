<?php
    /*
    1. if, else, elseif
    2. switch
    3. Ciklusok: for, while, foreach
    4. Ternary operator ?:
    5. Tömbök (indexelt, asszociatív, tömbök tömbje)
    */
    // egy számról döntsd el h az páros e
    $number = 6;
    echo "A(z) {$number} egy ";
    if ($number % 2 == 0) {
        echo "páros";
    } else { 
        echo "páratlan";
    }
    echo " szám.<br>";

    $result = ($number % 2 == 0) ? "páros" : "páratlan";
    echo "A(z) $number egy $result szám.<br>";
    
    //ciklussal írasd ki 1-10 ig a számokat
    for ($i=0; $i < 10 ; $i++) { 
        $out = $i +1;
        echo "{$out}<br>";
    }

    //hozz létre egy indexelt tömböt 5 gyümölccsel és írasd ki
    $fruits = ["apple", "apricot", "banana", "orange", "plum"];
    //$things = array("this", "that");

    for ($i=0; $i < count($fruits); $i++) { 
        echo "$fruits[$i], ";
    }

    echo "<br>";
    foreach ($fruits as $fruit) {
        echo "$fruit, ";
    }
    
    // hozd létre a users tömböt, ami tartalmazza a userek nevét és életkorát
    $users = [
        "Kiss Pista" => 20,
        "Nagy Tibi" => 21,
        "Koós Géza" => 30
    ];

    echo "<br>";
    foreach ($users as $name => $age) {
        echo "$name: $age éves.<br>";
    }

    //vegyünk fel egy students tömböt ami tömbök tömbje legyen
    $students = [
        ["name" => "Kovács Péter", "age" => 20],
        ["name" => "Tóth Géza", "age" => 21],
        ["name" => "Kiss Ica", "age" => 23]
    ];

    echo "<br>";
    foreach ($students as $student) {
        echo "{$student['name']}  kora: {$student['age']} év.<br>";
    }

    //Hf: users tömb, ami majd lehetővé teszi az autehtikációt, foreach-el írasd ki

?>