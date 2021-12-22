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
$orig=$_POST['orig'];
$dest=$_POST['dest'];
$hora=$_POST['time'];
$fecha=$_POST['part'];
$sql2="SELECT v.id,v.precio,v.hora,v.asientosdisp,v.vehiculo,c.nombre,c.apellido 
FROM viajes v
JOIN conductor c ON v.conductorID=c.id 
WHERE v.origen='$orig' AND v.destino='$dest' AND v.fecha='$fecha'";
  $ejec2= mysql_query($sql2);
  if(!$ejec2){
    echo "Hay un error en la sentencia de sql:".$sql2;
  }else{
      if(mysql_num_rows($ejec2)==0){
        $error="No se encontraron viajes para esa fecha";
    }
    
  };

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
  <table class="table">
  <thead>
      <?php if(!empty($error)):?>
        <h2 style="color:red"><?=$error;?></h2>
        <?php endif; ?>
        
    <tr>
      <th scope="col">Nombre conductor</th>
      <th scope="col">Precio</th>
      <th scope="col">Hora</th>
      <th scope="col">Asientos disp</th>
      <th scope="col">Vehiculo</th>
      <th scope="col">Seleccionar viaje</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row=mysql_fetch_array($ejec2)): ?>
        <tr>
        <td><?=$row['nombre']; ?> <?=$row['apellido']; ?></td>
        <td><?=$row['precio']; ?></td>
        <td><?=$row['hora']; ?></td>
        <td><?=$row['asientosdisp']; ?></td>
        <td><?=$row['vehiculo']; ?></td>
        <td><input type='radio' name='x' value="<?=$row['id']; ?>"></input></td>
        </tr>
    <?php endwhile; ?>
</tbody>
</table>
    <div class="d-flex justify-content-end">
              <div class="d-grip gap-2">
                  <button class="btn btn-primary" type="button" onclick="elegido()">Seleccionar</button>                
              </div>
    </div>
    <br>
        <div class="d-flex justify-content-start">
        <div class="row">
        <div class="col" id="foto"></div>
         <div class="col">
            <input type="text" id="nombre" disabled readonly></input>
         </div>
         <div class="col">
         <input type="text" id="apellido" disabled readonly></input>
         </div>
         <div class="col">
         <input type="text" id="patente" disabled readonly></input>
         </div>
        </div> 
        </div>
        <div class="d-flex justify-content-end">
                <div class="row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                  </div>
                  <div class="col">
                    <form action="./travel.php">
                      <button type="submit" class="btn btn-danger">Cancelar</button>
                    </form>
                </div>
                </div>
            </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./conduc.js"></script>
    
</html>