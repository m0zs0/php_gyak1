<?php
    namespace App\Traits;

    trait LoggerTrait{
        public function log($message="Siker"){
            echo "[LOG]: $message\n";
        }
    }
?>