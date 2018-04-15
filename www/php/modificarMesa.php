<?php
include 'conexion.php';
$orden=$_POST['orden'];
$mesa=$_POST['mesa'];
$mesero=$_POST['mesero'];
$ref=$_POST['referencia'];
if(isset($_POST['mesa']) && isset($_POST['mesero']) && isset($_POST['referencia']) && isset($_POST['orden'])){
	if($mesa=="" || $mesero=="" || $ref=="" || $orden==""){
		header("Location: ../ordenes.php?id=0&clave=0&mesa=0&error=No se han llenado todos los campos");
	}else{
		if($orden=="0"){
			header("Location: ../ordenes.php?id=0&clave=0&mesa=0&error=No se ha seleccionado una orden para modificar");
		}else{
			$mysqli->query("update referencia set mesa =".$mesa.", mesero='".$mesero."', referencia='".$ref."' where idRef=".$orden)or die("ERROR: " .$mysqli->error);
			header("Location: ../ordenes.php?mensaje=Datos de la orden modificados&id=0&clave=0&mesa=".$orden);
		}
	}
	}else{
		//header("Location: ../registro.php?error=Campos Vacios" );
	}
 ?>
