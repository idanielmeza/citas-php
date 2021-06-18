<?php

//Importar conexion
require 'config/db.php';
$db = conectarDB();

//Crear email y password
$usuario = 'felipe';
$password = '1234509876';

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//query
$query = "INSERT INTO usuarios (usuario,password) VALUES ('${usuario}', '${passwordHash}')";

//agregarlo a la bd
mysqli_query($db,$query);