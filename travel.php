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
        <?php if(!empty($user)): ?>
        <?php else: ?>
            <h1>Porfavor Ingrese con su usuario o Registrese</h1>
            <a href="login.php">Ingresar</a>
            <a href="register.php">Registrarse</a>
              <?php endif; ?>
              <h2>Buscar Viaje</h2>
            <form action="./travelaval.php" method="POST" class="column g-3">
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="orig" placeholder="Buscar origen" required>
              <label for="orig" class="form-label">Origen</label>
            </div>
            <br>
            <div class="form-floating col-5">
                <input type="text" class="form-control" name="dest" placeholder="Buscar destino" required>
                <label for="dest" class="form-label">Destino</label>
            </div>
            <br>
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="part" placeholder="Fecha de partida" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])"  required/>
              <label for="part" class="form-label">Fecha de partida</label>
              <p>Formato:yyyy-mm-dd</p>
            </div>
            <br>
            <div class="form-floating col-5">
            <input type="text" class="form-control" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" name="time" id="24h" placeholder="Hora de partida" required/>
              <label for="time" class="form-label">Hora de partida</label>
              <p>Formato: hh:mm</p>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Buscar Viaje</button>
          
          </form>
    </div>
    
</body>
</html>