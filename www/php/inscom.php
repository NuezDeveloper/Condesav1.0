<?php
include 'conexion.php';
$id=$_POST['id'];
$com=$_POST['com'];
if(isset($_POST['id']) && isset($_POST['com'])){
	if($id=="" || $com==""){
		header("Location: ../ordenes.php?id=0&clave=0&mesa=0&error=No se han llenado los campos");
	}else{
    if($id==0){
  		header("Location: ../ordenes.php?id=0&clave=0&mesa=0&error=No se ha elegido una orden");
    }else{
      $mysqli->query("insert into comentarios values($id,'$com')")or die("ERROR: " .$mysqli->error);
  		header("Location: ../ordenes.php?id=0&clave=0&mesa=".$mysqli->insert_id);
    }
	}
	}else{
		//header("Location: ../registro.php?error=Campos Vacios" );
	}
 ?>
