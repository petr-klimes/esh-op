<?php

function __autoload($class) {

    //print_r($class . ' | ');
    if(file_exists($class . '.php')){
        include '\\' . $class . '.php';
    }
    
}
