<?php

namespace App\Models;

class Person{
    protected ?int $id;
    public string $name;
    protected string $email;
    private string $phone;

    public function __construct(?int $id, string $name, string $email, string $phone){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    // accessor: getter, setter
    public function getEmail(): string
    {
        return $this->email;
    }

    //getter
    public function getPhone(): string{
        return $this->phone;
    }

    //setter
    public function setPhone(string $phone): void{
        $this->phone = $phone;
    }
     
}
?>