<?php
session_start();
if(isset($_SESSION['user_id'])){
}else{
    header('Location:login.php');
}
require './database.php';
$base=mysql_select_db('usuarios');
if (isset($_SESSION['user_id'])){
    $user=null;
    $aux=$_SESSION['user_id'];
    $sql="SELECT id, usuario,contra FROM usuarios WHERE id=$aux";
    $ejec=mysql_query($sql);
    if(!$ejec){
        echo 'Ocurrio un error';
    }else{
        $res=mysql_fetch_array($ejec);
        if(count($res)>0){
            $user=$res;
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
    <title>Subi que te llevo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./estilos.css" rel="stylesheet">
</head>
<body style="background-color: grey;">
    <nav class="navbar sticky-top navbar-expand-lg ">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <div class="mx-auto"></div>
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="./index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="./logout.php">Cerrar sesion</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="row">
            <?php if(!empty($user)): ?>
                    <br><h1>Bienvenido, <?= $user['usuario']?></h1>
            <?php else: ?>
                <h1>Porfavor Ingrese con su usuario o Registrese</h1>
                <a href="login.php">Ingresar</a>
                <a href="register.php">Registrarse</a>
                  <?php endif; ?>
            <div class="col-5">
                <form action="./travel.php">
                              <button type="submit" class="btn btn-primary">Buscar Viaje</button>
                </form>
            </div>
            <div class="col-7">
                <form action="">
                          <button type="submit" class="btn btn-primary">Viajes Programados</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    
</body>
</html>