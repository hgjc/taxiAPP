
<?php
session_start();
if(isset($_SESSION['user_id'])){
  header('Location:index.php');
}
require './database.php';
$base=mysql_select_db('usuarios');

$message='';
if (!empty($_POST['user']) && !empty($_POST['pass'])){
  $uppercase = preg_match('@[A-Z]@', $_POST['pass']);
  $lowercase = preg_match('@[a-z]@', $_POST['pass']);
  $number    = preg_match('@[0-9]@', $_POST['pass']);
  $specialChars = preg_match('@[^\w]@', $_POST['pass']);
  if(strlen($_POST['user']<= 8 && strlen($_POST['user'])>= 4)){
    if(!$uppercase || !$lowercase || !$number || !$specialChars || (strlen($_POST['pass']) <= 8 && strlen($_POST['pass']>=4))){
      $passerr ='La contraseña debe tener 4-8 carácteres y debe incluir al menos una letra mayúscula, un numero y un carácter especial.';  
   
    }else{
      $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);
      $user = $_POST['user'];
      $nom = $_POST['nom'];
      $ape = $_POST['ape'];
      $dni = $_POST['dni'];
      $gen = $_POST['gen'];
      $mail = $_POST['mail'];
      $phone = $_POST['phone'];
      $nac = $_POST['nac'];
      $photo = $_FILES['photo']['tmp_name'];
      $imgContenido = addslashes(file_get_contents($photo));
      $sql = "INSERT INTO usuarios (usuario,contra,nom,ape,dni,gen,mail,phone,nac,foto) VALUES ('$user', '$password','$nom','$ape','$dni','$gen','$mail','$phone','$nac','$imgContenido')";
      $stmt = mysql_query($sql);
      
      
      if (!$stmt){
        $message = 'Sorry there must have been an issue creating your account' .$stmt;
        
      }else{
        $message = 'Succesfully created new user';
        header("Location:login.php?".$message);
      }

  }
}else{
  $usererr='El usuario debe tener 4-8 carácteres';
};
  
};
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Registro</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./estilos.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <h1>Registrarse</h1>
      
      <form action="./register.php" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="nom" placeholder="Nombre" required>
              <label for="nom" class="form-label">Nombre</label>
            </div>
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="ape" placeholder="Apellido" required>
              <label for="ape" class="form-label">Apellido</label>
            </div>
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="user" placeholder="Usuario" required>
              <label for="user" class="form-label">Usuario</label>
              <?php if(!empty($usererr)): ?>
              <p><?= $usererr ?></p>
              <?php endif; ?>
            </div>
            <div class="form-floating col-5">
              <input type="password" class="form-control" name="pass" placeholder="Password" required>
              <label for="pass" class="form-label">Password</label>
              <?php if(!empty($passerr)): ?>
              <p><?= $passerr ?></p>
              <?php endif; ?>
            </div>
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="dni" placeholder="DNI" required>
              <label for="dni" class="form-label">DNI</label>
            </div>
            <div class="form-floating col-5">
              <select name="gen" class="form-select" placeholder="Género" required>
                <option selected>Elegir</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="No Binario">No Binario</option>
              </select>
              <label for="gen" class="form-label">Género:</label>
            </div>
            <div class="form-floating col-5">
              <input type="email" class="form-control" name="mail" placeholder="Mail" required>
              <label for="mail" class="form-label">Mail</label>
            </div>
            <div class="form-floating col-5">
              <input type="tel" class="form-control" name="phone" placeholder="Telefono" pattern="[0-1]{2}-[0-9]{4}-[0-9]{4}" required>
              <label for="phone" class="form-label">Telefono</label>
              <p>Formato:xx-xxxx-xxxx</p>
            </div>
            <div class="form-floating col-5">
              <input type="text" class="form-control" name="nac" placeholder="Fecha de Nacimiento" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])"  required/>
              <label for="nac" class="form-label">Fecha de nacimiento</label>
              <p>Formato:yyyy-mm-dd</p>
            </div>
            <div class="form-floating col-5">
              <input type="file" class="form-control" name="photo" id="photo" required multiple>
              <label for="photo" class="form-label">Inserte su foto</label>
            </div>
            
            <div class="d-flex justify-content-end">
                <div class="row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                  </div>
                  <div class="col">
                    <form action="./login.php">
                      <button type="submit" class="btn btn-danger">Cancelar</button>
                    </form>
                </div>
                </div>
            </div>
            
          
          <?php if(!empty($message)): ?>
          <p><?= $message ?></p>
          <?php endif; ?>
        </div>
  </body>
  </html>