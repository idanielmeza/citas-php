<?php

function conectarDB(): mysqli{
    $db = mysqli_connect('localhost','root','','citas');

    if(!$db){
        echo 'Error db conecto';
        exit;
    }

    return $db;
}