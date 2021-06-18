<?php
    require '../config/funciones.php';
    $auth = autenticado();

    if(!$auth){
        header("Location: /" );
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require '../config/db.php';

        $db = conectarDB();

        $paciente = mysqli_real_escape_string($db,$_POST['Paciente']);
        $fecha = mysqli_real_escape_string($db,$_POST['Fecha']);
        $hora = mysqli_real_escape_string($db,$_POST['Hora']);
        $telefono = mysqli_real_escape_string($db,$_POST['Telefono']);
        $correo = mysqli_real_escape_string($db,$_POST['Correo']);
        $comentarios = mysqli_real_escape_string($db,$_POST['Comentarios']);

        //insertar en la base de datos
        $query = "insert into citas (Paciente,Fecha,Hora,Telefono,Correo,Comentarios) VALUES ('$paciente', '$fecha', '$hora', '$telefono', '$correo', '$comentarios')";

        // echo $query;

        $resultado = mysqli_query($db,$query);

        if($resultado){
            // echo 'Insertado correctamente';
            //Redireccionar al usuario

            header('Location: /');
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

    <nav class="navbar navbar-light bg-light justify-content-between">
        <a href='/' class="btn btn-light" href="#" role="button">
            <h2>Dr Felipe Castillo</h2>
        </a>
        <form class="form-inline">
            <div class='justify-content-end'>
                <a href='/logout.php' class="btn btn-outline-danger my-2 my-sm-0" type="button">Cerrar Sesion</a>
            </div>
        </form>
    </nav>


    <div class='container mt-5 py-5'>
        <div class='row'>

            <div class='col-md-8 mx-auto'>

                <h1 class='text-center'>Crea una nueva cita</h1>
                
                <form 
                class="bg-white p-5 bordered"
                method='POST' action='/citas/crear.php' enctype='multipart/form-data'
                >

                    <div class="form-group">
                        <label for="Paciente">Paciente</label>
                        <input 
                            type="text" 
                            class="form-control form-control-lg" 
                            id="Paciente" 
                            name="Paciente" 
                            placeholder="Paciente" 
                            maxlength="50"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="Fecha">Fecha</label>
                        <input 
                            type="date" 
                            class="form-control form-control-lg" 
                            id="Fecha" 
                            name="Fecha"  
                            required
                            min ="<?php echo date('Y-m-d');?>"
                            value ="<?php echo date('Y-m-d');?>"
                            
                        />
                    </div>

                    <div class="form-group">
                        <label for="Hora">Hora</label>
                        <input 
                            type="time" 
                            class="form-control form-control-lg" 
                            id="Hora" 
                            name="Hora"
                            required
                        />
                    </div>
                    
                    <div class="form-group">
                        <label for="Telefono">Teléfono</label>
                        <input 
                            type="tel" 
                            class="form-control form-control-lg" 
                            id="Telefono" 
                            name="Telefono" 
                            placeholder="Teléfono" 
                            maxlength="10"
                        />
                    </div>
                    
                    <div class="form-group">
                        <label for="Correo">Correo</label>
                        <input 
                            type="email" 
                            class="form-control form-control-lg" 
                            id="Correo" 
                            name="Correo" 
                            placeholder="Correo" 
                            maxlength="50"
                        />
                    </div>

                    <div class="form-group">
                        <label for="Comentarios">Comentarios</label>
                        <textarea 
                            class="form-control" 
                            name="Comentarios" 
                            rows="3"
                            maxlength="250"
                        ></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary mt-3 w-100 p-3 text-uppercase font-weight-bold" value="Crear Cita"  />
                </form>
                    
            </div>
        </div>
    </div>
    
</body>

</html>