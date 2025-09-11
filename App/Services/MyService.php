<?php
    namespace App\Services;
    
    use App\Traits\GreetingTrait;
    use App\Traits\LoggerTrait;

    class MyService{
        use GreetingTrait, LoggerTrait;

        public function run($name="User"){
            $this -> log("Service elindult!");
            echo $this -> greet("mozso");
        }

    }
?>