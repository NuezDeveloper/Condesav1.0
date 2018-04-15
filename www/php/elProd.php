<?php
	include 'conexion.php';
	$prod=$_POST['id'];
	if(isset($_POST['id'])){
		if($prod==""){
			header("Location: ../inventario.php?error=Campos Vacios&id=0&clave=0&mesa=0");
		}else{
  		$mysqli->query("delete from productos where idProducto=".$prod."")or die($mysqli->error);
  		header("Location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Producto eliminado");
		}
	}
?>
