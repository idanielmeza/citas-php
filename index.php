<?php
    require 'config/funciones.php';
    $auth = autenticado();

    if(!$auth){
        header("Location: /login.php" );
    }

    //Importar conexion
    require 'config/db.php';

    $db = conectarDB();

    $resultado = $_GET['fecha'] ?? null;

    if(!$resultado){
        $query = "SELECT * FROM citas WHERE Fecha = CURDATE()";
    }else{
        $query = "SELECT * FROM citas WHERE Fecha = '$resultado'";
    }

    //Consultar base de datos
    $resultadoConsulta = mysqli_query($db, $query);



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
    <div class='align-items-center'>
        <a href='/' class="btn btn-light" href="#" role="button">
            <h2 class='text-center'>Dr Felipe Castillo</h2>
    </div>
    </a>
    <form class="form-inline">
        <div class='justify-content-end'>
            <a href='/citas/crear.php' class="btn btn-outline-primary my-2 my-sm-0 ml-5" type="button">Nueva Cita</a>
            <a href='logout.php' class="btn btn-outline-danger my-2 my-sm-0" type="button">Cerrar Sesion</a>
        </div>
        
    </form>
    </nav>
    
    <div class='container mt-5 py-5'>

        <div class='row'>
            <div class='col-md-8 mx-auto'>
                <h2>Busca por fecha</h2>
                    <form action="/" method="get">
                        <div class="form-group">
                        <input 
                            type="date" 
                            class="form-control form-control-lg" 
                            id="fecha" 
                            name="fecha"
                            value ="<?php echo date('Y-m-d');?>"
                        />
                        <div class='justify-content-end'>
                            <input type="submit" value="Buscar" class='btn btn-primary mt-2'>
                        </div>
                        </div>
                    </form>
                

                <div class="row">
                        
                    <?php while($paciente = mysqli_fetch_assoc($resultadoConsulta)): ?>
                        
                        <div class="col">

                            <a href="citas/editar.php?id=<?php echo $paciente['id'];?>" class='p-3 list-group-item list-group-item-action flex-column align-items-start mb-4'>
                                <div class='d-flex w-100 justify-content-between mb-4'>
                                    <h4  class='mb-3'><?php echo trim(substr($paciente['Paciente'],0,20)) . '...';?></h4>
                                    <small class='fecha'>
                                        <?php echo $paciente['Fecha'];?>
                                    </small>
                                </div>
                                <p class='mb-0'>
                                    <?php echo $paciente['Hora'];?>
                                </p>
                                <div class='py-3'>
                                    <p>Telefono: <?php echo $paciente['Telefono'];?></p>
                                    <p>Correo: <?php echo $paciente['Correo'];?> </p>
                                </div>
                            </a>
                        </div>    

                    <?php endwhile; ?>     
                                        
                </div>
                
            </div>
        
        </div>

    </div>



</body>

</html>
