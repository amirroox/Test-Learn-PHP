<?php


spl_autoload_register(function ($class){
   $full_name = __DIR__ . "\\$class.php" ;
   if(!file_exists($full_name)) die('Class Not Excited ! ');
   include_once "$full_name";
});
