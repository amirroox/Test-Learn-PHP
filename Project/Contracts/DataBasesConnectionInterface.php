<?php

namespace App\Contracts ;

interface DataBasesConnectionInterface {
    public function connect();
    public function GetConnection();

}
