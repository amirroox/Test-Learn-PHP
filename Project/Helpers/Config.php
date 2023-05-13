<?php
namespace App\Helpers;

use App\Exceptions\NotLoadConfigDataBaseException;

class Config {

    /**
     * @throws NotLoadConfigDataBaseException
     */
    public static function ReadFileConfigDataBase(string $filename) {
        $FilePath = realpath(__DIR__ . '/../Config/' . $filename . ".php");
        if (!file_exists($FilePath)) throw new NotLoadConfigDataBaseException;
        return require $FilePath;
    }

    /**
     * @throws NotLoadConfigDataBaseException
     */
    public static function GetFileConfigDataBase(string $filename , string $key = null) {
        $File = self::ReadFileConfigDataBase($filename);
        if (is_null($key)) return $File;
        return $File[$key] ?? $File;
    }
}
