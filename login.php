<?php

    require 'config/db.php';
    $db = conectarDB();

    $errores = [];

    //Autenticar usuario
    if($_SERVER['REQUEST_METHOD']==='POST'){

        $usuario = mysqli_real_escape_string($db,$_POST['usuario']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
    
        if(!$usuario){
            $errores[] = 'El usuario no es valido';
        }
    
        if(!$password){
            $errores[] = 'El password no es valido';
        }

        if(empty($errores)){
            //revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE usuario = '${usuario}' ";
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                //Verificar si el password es correcto o no

                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    //El usuario esta autenticado
                    session_start();
                    //Llenar arreglo sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /');

                }else{
                    $errores[] = 'ELa contraseña es incorrecta';
                }

            }else{
                $errores[] = 'El usuario no existe';
            }
        }
        
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Dr Felipe Castillo</title>
</head>
<body>
    
    <div class='container mt-5 py-5'>

        <div class='row'>

            <div class='col-md-8 mx-auto'>

                <form class="bg-white p-5 bordered" method='POST'>

                    <h3 class='text-center'>Inicia sesion</h3>

                    <div class='form-group'>
                        <label for='usuario' class='p-2'>Usuario</label>
                        <input id='usuario' placeholder='Usuario' class='form-control form-control' type='text' name='usuario' required>
                    </div>
                    
                    <div class='form-group'>
                        <label for="password" class='p-2'>Contraseña</label>
                        <input id='password' placeholder='Contraseña' class='form-control form-control' type='password' name='password' required>
                    </div>

                    <input type='submit' value='Conectar' class='btn btn-primary form-control btn-block'>

                </form>

                <?php foreach($errores as $error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach;?>

            </div>
        
        </div>

    </div>
    


</body>
</html>