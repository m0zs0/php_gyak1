<?php
    /*
    Szükséges programok: XAMPP (Apache, MySQL), Git, github repo, VSC
    <?php ...   ?>
    Változók

    */

    $name = "mozso";
    $age = 18;
    $city = "Kisújszállás";
    var_dump($name);

    echo "\n<br>\nNév: $name Életkor: $age Lakóhely: $city";
    //Konstans
    define("PI", 3.14);
    echo "<br>", PI;

    //adattípusok: string, int, float, bool, array
    //mit ír ki?
    $message = "egy";
    echo "Kiír", $message, "értéket.","<br>\n";
    echo "Kiír $message értéket. <br>\n";
    echo "Kiír {$message}darab értéket. <br>\n";
    echo 'Kiír {$message}darab értéket. <br>\n';

    print "Kiír". $message. "értéket."."<br>\n";
    print "Kiír {$message}darab értéket. <br>\n";
    print 'Kiír {$message}darab értéket. <br>\n';

    /*
    git parancsok
        git init : 
        git add . : 
        git commit -m "message" : 
        git remote add origin https://github.com/felhnev/reponeve.git : 
           git config --global user.name ill email: 
        git branch -M main :
        git push -u origin main : 
        
        HF: töltsd le otthon a repot a saját htdocs mappádba 
        git clone https://github.com/felhnev/reponeve.git


    */
?>

