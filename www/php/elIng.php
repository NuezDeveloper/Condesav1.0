<?php
	include 'conexion.php';
	$prod=$_POST['id'];
	$prodd=$_POST['bp'];
	if(isset($_POST['id'])&&isset($_POST['bp'])){
		if($prod==""&&$prodd==""){
			header("Location: ../inventario.php?error=Campos Vacios&id=0&clave=0&mesa=0");
		}else{
  		$mysqli->query("delete from inventario where idIngrediente=".$prod."")or die($mysqli->error);
			$mysqli->query("delete from ingredientes where ingredientes='".$prodd."'")or die($mysqli->error);
  		header("Location: ../inventario.php?id=0&clave=0&mesa=0");
		}
	}
?>
