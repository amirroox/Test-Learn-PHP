<?php

namespace App\Models;
class Users {
    protected string $FirstName;
    protected string $LastName;
    protected string $FullName;

    public function __call(string $name, array $arguments)
    {
        $property = substr($name , 3);
        if(property_exists($this , $property)) {
            if (!empty($arguments)) $this->$property = $arguments[0];
            else return $this->$property ;
        }
        else {
            echo("Property Not Excited ! ");
        }
        return false;
    }
    public function SetFullName(): void
    {
        $this->FullName = trim($this->FirstName . ' ' . $this->LastName) ;
    }

    public function getFullName(): string
    {
        return $this->FullName;
    }
}