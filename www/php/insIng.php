<?php
include 'conexion.php';
$ing=$_POST['ing'];
$clave=$_POST['clave'];
$cantidad=$_POST['cantidad'];
if(isset($_POST['ing']) && isset($_POST['clave']) && isset($_POST['cantidad'])){
	if($ing=="" || $clave=="" || $cantidad ==""){
		header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=No se han llenado todos los campos");
	}else{
		if($clave=="0"){
			header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=Favor de seleccionar un producto");
		}else{
			$mysqli->query("insert into ingredientes values($clave,'$ing',$cantidad)")or die("ERROR: " .$mysqli->error);
			header("Location: ../inventario.php?id=0&clave=$clave&mesa=0");
		}
	}
	}else{
		//header("Location: ../registro.php?error=Campos Vacios" );
	}
 ?>
