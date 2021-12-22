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
};


function mostrar($id){
    $resp= array();
    $sql3="SELECT v.id,v.precio,v.hora,v.asientosdisp,v.vehiculo,c.nombre,c.apellido,c.patente,c.foto
    FROM viajes v
    JOIN conductor c ON v.conductorID=c.id 
    WHERE v.id='$id'";
    $ejec3= mysql_query($sql3);
    if(!$ejec3){
        echo "Hay un error en la sentencia de sql:".$sql3;
      }else{
        $aux= mysql_fetch_array($ejec3);
        for($i=0;$i<1;$i++){
            array_push($resp,$aux['nombre']);
            array_push($resp,$aux['apellido']);
            array_push($resp,$aux['patente']);
            $xx='<img width="150" src="data:image/jpeg;base64,'.base64_encode($aux['foto']).'"/>';
            array_push($resp,$xx);
        };
        $pl=json_encode($resp);
        return $pl;
      }
};
if (isset($_POST['id'])){
    echo mostrar($_POST['id']);
};
?>