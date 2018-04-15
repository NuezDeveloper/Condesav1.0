<?php
	include 'conexion.php';
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$cpass=$_POST['cpass'];
	$permiso=$_POST['permiso'];
	if(isset($_POST['user'])&&isset($_POST['pass'])){
		if($user=="" && $pass==""){
			header("Location: ../usuarios.php?id=0error=Favor de llenar todos los campos");
		}else{
			if($pass==$cpass){
				$encriptada=sha1($pass);
				$mysqli->query("insert into usuarios values(0,'$user','$encriptada','$permiso')")or die($mysqli->error());
				header("Location: ../usuarios.php?id=0&mensaje=Usuario agregado");
			}else{
				header("Location: ../usuarios.php?id=0&error=Las contraseñas no coinciden");
			}
		}
	}
?>
