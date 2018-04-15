<?php
include 'conexion.php';
$ing=$_POST['ing'];
$clave=$_POST['can'];
$minimo=$_POST['minimo'];
if(isset($_POST['ing']) && isset($_POST['can']) && isset($_POST['minimo'])){
	if($ing=="" || $clave==""){
		header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=Campos vacios");
	}else{
		if($clave=="0"){
			header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=Se ha dejado la cantidad del producto en 0");
		}else{
			$mysqli->query("insert into inventario values(0,'$ing',$clave,$minimo)")or die("ERROR: " .$mysqli->error);
			header("Location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Ingrediente agregado");
		}
	}
	}else{
		//header("Location: ../registro.php?error=Campos Vacios" );
	}
 ?>
