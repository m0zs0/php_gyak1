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
    echo "A(z) $number egy $result szám.";
    

?>