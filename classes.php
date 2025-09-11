<?php
    /*osztály
    -osztály, objektum
    -Konstruktor/destruktor
    -Tulajdonságok (public, private, protedted)
    -Öröklődés (extends)
    -Trait (fgv-ek, amiket különböző osztályból szeretnék elérni)
    */

    // Készíts Car osztályt, márka, típus, szín tulajdonsággal, Konstruktor is legyen

    class Car{
        public $brand;
        public $type;
        private $color;

        public function __construct($brand, $type, $color){
            $this->brand = $brand;
            $this->type = $type;
            $this->color = $color;
        }

        public function info(){
            echo "$this->brand $this->type $this->color";
        }
    }

    $car = new Car ("BMW","M5","piros");
    $car -> info();
    //echo $car -> color; 


    // Hozz létre a MathHelper osztályt, amiben legyen egy statikus változó (pi) és egy statikus metódus square néven.
    
    class MathHelper{
        public static $pi = 3.14;

        public static function square($num){
            return $num*$num;
        }
    }

    echo MathHelper::$pi;
    echo MathHelper::square(5);

    // Készíts egy ElectricCar osztályt, ami örökli a Car-t, és pluszban tartalmaz batteryCapacity tulajdonságot

    class ElectricCar extends Car{
        public $batteryCapacity;

        public function __construct($brand, $type, $color, $batteryCapacity){
            parent::__construct($brand, $type, $color);
            $this -> batteryCapacity = $batteryCapacity;
        }

        public function info(){
            parent::info();
            echo "Akkumulátorkapacitása: {$this->batteryCapacity} kWh.";

        }

    }

    $eCar = new ElectricCar("Tesla","Model 3","fehér",10000);
    $eCar -> info();

    // Traitek: újrahasznosítható függvényeket tartalmazó tároló
    //Hozz létre egy trait-et, ami tartalmaz egy metódust, ami kiírja "Szia [név]!"

    trait GreetingTrait{
        public function greet($name="Guest"){
            echo "Szia {$name}";
        }
    }

    class User{
        use GreetingTrait; // trait importálása

    }

    class Admin{
        use GreetingTrait;
    }

    $user = new User();
    $user -> greet();

    $admin = new Admin();
    $admin -> greet("mozso");
?> 


