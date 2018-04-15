<?php
	include 'conexion.php';
	$orden=$_POST['borrar'];
	if(isset($_POST['borrar'])){
		if($orden==""||$orden=="0"){
			header("Location: ../ordenes.php?error=No se ha seleccionado orden para eliminar&id=0&clave=0&mesa=0");
		}else{
			$mysqli->query("delete from referencia where idRef=".$orden)or die($mysqli->error);
			$mysqli->query("delete from detalle_orden where idOrden=".$orden)or die($mysqli->error);
			$mysqli->query("delete from orden where idOrden=".$orden)or die($mysqli->error);
			header("Location: ../ordenes.php?id=0&clave=0&mesa=0");
		}
	}
?>
