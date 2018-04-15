<?php
	include 'conexion.php';
	$prod=$_POST['clave'];
	if(isset($_POST['clave'])){
		if($prod==""){
			header("Location: ../usuarios.php?error=Favor de ingresar un valor&id=0");
		}else{
				$getProd2 = $mysqli->query("select * from empleados where nombre like '%".$prod."%'")or die($mysqli->error);
				if($registro=mysqli_fetch_array($getProd2)){
          header("Location: ../usuarios.php?id=".$registro['idEmpleado']);
				}else{
					header("Location: ../usuarios.php?id=0&error=No existe personal con estos datos");
				}
		}
	}
?>
