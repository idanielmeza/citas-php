<?php

    require '../config/funciones.php';
    $auth = autenticado();

    if(!$auth){
        header("Location: /" );
    }

    //Validar URL por ID valido
    $id = $_GET['id']; 
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /citas');
    }

    //Base de datos

    require '../config/db.php';

    $db = conectarDB();

    //Consulta para obtener los datos de la propiedad
    $consultaDatos = "SELECT * FROM citas where id = ${id}";
    $resultadoDatos = mysqli_query($db, $consultaDatos);
    $paciente = mysqli_fetch_assoc($resultadoDatos);

    $nombre = $paciente['Paciente'];
    $fecha = $paciente['Fecha'];
    $hora = $paciente['Hora'];
    $telefono = $paciente['Telefono'];
    $correo = $paciente['Correo'];
    $comentarios = $paciente['Comentarios'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $nombre = mysqli_real_escape_string($db,$_POST['Paciente']);
        $fecha = mysqli_real_escape_string($db,$_POST['Fecha']);
        $hora = mysqli_real_escape_string($db,$_POST['Hora']);
        $telefono = mysqli_real_escape_string($db,$_POST['Telefono']);
        $correo = mysqli_real_escape_string($db,$_POST['Correo']);
        $comentarios = mysqli_real_escape_string($db,$_POST['Comentarios']);

        //insertar en la base de datos
        $query = "UPDATE citas SET Paciente = '${nombre}', Fecha = '${fecha}' ,Hora = '${hora}', Telefono = '${telefono}', Correo= '${correo}', Comentarios = '${comentarios}' WHERE id = ${id}";
        echo $query;

        $resultado = mysqli_query($db,$query);

        if($resultado){
            header('Location: /?fecha='.$fecha);
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

                <form class="bg-white p-5 bordered" method='POST' action='/citas/editar.php?id=<?php echo $id; ?>' enctype='multipart/form-data'>

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
                            value="<?php echo $nombre; ?>"
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
                            value="<?php echo $fecha; ?>"
                            
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
                            value="<?php echo $hora; ?>"
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
                            value="<?php echo $telefono; ?>"
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
                            value="<?php echo $correo; ?>"
                        />
                    </div>

                    <div class="form-group">
                        <label for="Comentarios">Comentarios</label>
                        <textarea 
                            class="form-control" 
                            name="Comentarios" 
                            rows="3"
                            maxlength="250"
                        ><?php echo $comentarios; ?></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary mt-3 w-100 p-3 text-uppercase font-weight-bold" value="Guardar Cambios"/>
                </form>
                    
            </div>
        </div>
    </div>
    
</body>

</html>