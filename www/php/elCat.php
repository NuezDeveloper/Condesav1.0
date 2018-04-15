<?php
	include 'conexion.php';
	$prod=$_POST['id'];
	if(isset($_POST['id'])){
		if($prod==""){
			header("Location: ../inventario.php?error=Campos Vacios&id=0&clave=0&mesa=0");
		}else{
			$vercat = $mysqli->query("select * from categorias where idCategoria = $prod")or die($mysqli->error);
			while($encontro=mysqli_fetch_array($vercat)){
				$mysqli->query("delete from productos where categoria='".$encontro['categoria']."'")or die($mysqli->error);
			}
  		$mysqli->query("delete from categorias where idCategoria=".$prod."")or die($mysqli->error);
  		header("Location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Categoría eliminada");
		}
	}
?>
