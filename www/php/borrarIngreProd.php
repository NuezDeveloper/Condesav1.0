<?php
	include 'conexion.php';
	$prod=$_POST['biip'];
	$ingre=$_POST['bi'];
	if(isset($_POST['bi']) && isset($_POST['biip'])){
		if($prod=="" || $ingre==""){
			header("Location: ../inventario.php?error=Campos Vacios&id=0&clave=0&mesa=0");
		}else{
  		$mysqli->query("delete from ingredientes where idProducto = $prod and ingredientes = '$ingre'")or die($mysqli->error);
  		header("Location: ../inventario.php?id=0&clave=$prod&mesa=0");
		}
	}
?>
