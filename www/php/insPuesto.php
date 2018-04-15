<?php
	include 'conexion.php';
	$p=$_POST['puesto'];
	if(isset($_POST['puesto'])){
		if($p==""){
			header("Location: ../usuarios.php?error=Campos Vacios");
		}else{
			$mysqli->query("insert into puestos values(0,'$p')")or die("ERROR: " .$mysqli->error);
      header("Location: ../usuarios.php?id=0&mensaje=Puesto agregado");
		}
	}
?>
