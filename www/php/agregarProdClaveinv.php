<?php
	include 'conexion.php';
	$prod=$_POST['clave'];
	if(isset($_POST['clave'])){
		if($prod==""){
			header("Location: ../inventario.php?error=Favor de insertar un valor&clave=0&id=0&mesa=0");
		}else{
				$getProd2 = $mysqli->query("select * from productos where clave='".$prod."'")or die($mysqli->error);
				if($registro=mysqli_fetch_array($getProd2)){
          header("Location: ../inventario.php?mesa=0&clave=".$registro['idProducto']."&id=".$prod);
				}else{
					header("Location: ../inventario.php?clave=0&id=0&error=El producto no existe&mesa=0");
				}
		}
	}
?>
