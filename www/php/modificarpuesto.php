<?php
	include 'conexion.php';
	$p=$_POST['puesto'];
	$id=$_POST['id'];
	if(isset($_POST['puesto']) && isset($_POST['id'])){
		if($p=="" || $id==""){
			header("Location: ../usuarios.php?error=Campos Vacios");
		}else{
			if($id=="1"){
				header("Location: ../usuarios.php?id=0&error=Lo sentimos, este registro no puede ser modificado");
			}else{
				$mysqli->query("update puestos set puesto = '$p' where idPuesto = $id")or die("ERROR: " .$mysqli->error);
	      header("Location: ../usuarios.php?id=0&mensaje=Puesto modificado");
			}
		}
	}
?>
