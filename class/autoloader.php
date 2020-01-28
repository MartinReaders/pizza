<?php

//class autoiloadrer
class autoloader {
    
    
      static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
     static function autoload($class){
        require 'class/' . $class . '.php';
}

}
