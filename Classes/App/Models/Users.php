<?php

namespace App\Models;
class Users {
    protected string $FirstName;
    protected string $LastName;

    public function __call(string $name, array $arguments)
    {
        var_dump($name);
        var_dump($arguments);
    }
//    public function getFirstName(): string
//    {
//        return $this->FirstName;
//    }

//    public function setFirstName(string $FirstName): void
//    {
//        $this->FirstName = $FirstName;
//    }
}