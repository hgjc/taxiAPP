<?php
session_start();
$aux='';
if(isset($_SESSION['user_id'])){
  header('Location:index.php');
}
if(isset($_GET['message'])){
  $aux=$_GET['message'];
}
require './database.php';
if (!empty($_POST['user']) && !empty($_POST['pass'])){
  $base=mysql_select_db('usuarios');
  $user=$_POST['user'];
	$pass=$_POST['pass'];
	//hacemos la sentencia de sql
	$sql="SELECT id, usuario, contra FROM usuarios WHERE usuario='$user'";
  $ejec= mysql_query($sql);
  if(!$ejec){
    echo "Hay un error en la sentencia de sql:".$sql;
  }else{
    $lista_usu = mysql_fetch_array($ejec);
    $message='';
    if(count($lista_usu)>0 && password_verify($_POST['pass'],$lista_usu['contra'])){
      $_SESSION['user_id'] = $lista_usu['id'];
      header('Location:index.php');
      
    }else{
      $message= 'Sorry, Those credentials do not match';
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
<body>
    <div class="container">
    <?php if(!empty($aux)): ?>
          <p><?= $aux ?></p>
        <?php endif; ?>
      <?php if(!empty($message)): ?>
          <p><?= $message ?></p>
        <?php endif; ?>
        <div class="d-flex justify-content-center">
          <div class="d-grip gap-2">
            <h1>SUBI QUE TE LLEVO</h1>
        <form action="./login.php" method="POST">
            <div class="mb-4">
              <label for="user" class="form-label">Usuario</label>
              <input type="text" class="form-control" name="user" required>
            </div>
            <div class="mb-4">
              <label for="pass" class="form-label">Password</label>
              <input type="password" class="form-control" name="pass" required>
            </div>
            <div class="row">
              <div class="col">
                <button type="submit" class="btn btn-primary">Ingresar</button>
              </form>
            </div>
            <div class="col">
              <form action="./register.php">
              <button class="btn btn-primary" >Crear cuenta</button>
              </form>
            </div>
            </div>
            </div>
        </div>
        </div>
</body>
</html>