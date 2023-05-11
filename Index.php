<?php

include_once "vendor/autoload.php";

use App\Helpers\Config;

try {
    var_dump(Config::GetFileConfigDataBase('Database', 'PDO'));
} catch (\App\Exceptions\NotLoadConfigDataBaseException $e) {
    echo 'NotLoadConfigDataBaseException';
}

