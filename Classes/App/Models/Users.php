<?php

namespace App\Models;
class Users {
    protected string $FirstName;
    protected string $LastName;

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
}