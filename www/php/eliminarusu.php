<?php
	include 'conexion.php';
	$id=$_POST['id'];
	if(isset($_POST['id'])){
		if($id==""){
			header("Location: ../usuarios.php?error=No se ha seleccionado usuario&id=0");
		}else{
			if($id=="1"){
				header("Location: ../usuarios.php?id=0&error=Lo sentimos este registro no puede ser eliminado");
			}else{
				$mysqli->query("delete from usuarios where idUsuario=".$id)or die($mysqli->error);
	  		header("Location: ../usuarios.php?id=0&mensaje=Usuario eliminado");
			}
		}
	}
?>
