<?php
namespace App\Helpers ;


class Faker {
    public array $info = [
        "Name" => "" ,
        "Email" => "" ,
        "Age" => "" ,
        "Link" => ""
    ] ;
    public function __construct()
    {
        $this->info['Name'] = self::GenerateName();
        $this->info['Email'] = self::GenerateEmail();
        $this->info['Age'] = (string)mt_rand(16,60);
        $this->info['Link'] = 'https://'.
            str_replace(' ' , '',strtolower($this->info['Name'])) .
            '.com';
    }
    private function GenerateName(): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alphabet_s = strtolower($alphabet);
        $f_name = $l_name = null ;
        for($i = 0 ; $i < rand(5,10) ; $i++) {
            if ($i==0) $f_name .= $alphabet[mt_rand(0,25)];
            else $f_name .= $alphabet_s[mt_rand(0,25)];
        }
        for($i = 0 ; $i < rand(4,8) ; $i++) {
            if ($i==0) $l_name .= $alphabet[mt_rand(0,25)];
            else $l_name .= $alphabet_s[mt_rand(0,25)];
        }
        return $f_name . ' ' . $l_name ;

    }
    private function GenerateEmail(): string
    {
        $mail = ["@gmail.com" , "@yahoo.com" , "@hotmail.com"];
        $name = str_replace(' ' , '',$this->info['Name']);
        return $name . mt_rand(100,999) . $mail[rand(0,2)]  ;
    }
}