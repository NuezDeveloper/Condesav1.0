<?php
	include 'conexion.php';
	$id=$_POST['id'];
	if(isset($_POST['id'])){
		if($id==""||$id=="0"){
			header("Location: ../usuarios.php?error=Campos Vacios&id=0");
		}else{
			$mysqli->query("delete from empleados where idEmpleado=".$id)or die($mysqli->error);
  		header("Location: ../usuarios.php?id=0&mensaje=Personal eliminado");
		}
	}
?>
