<?php
include 'conexion.php';
$id=$_POST['id'];
$clave=$_POST['clave'];
$nom=$_POST['nom'];
$costo=$_POST['costo'];
$precio=$_POST['precio'];
$stock=$_POST['stock'];
$desc=$_POST['desc'];
$cat=$_POST['cat'];
if(isset($_POST['clave']) && isset($_POST['nom']) && isset($_POST['costo']) && isset($_POST['precio']) && isset($_POST['desc']) && isset($_POST['cat']) && isset($_POST['id'])){
	if($clave=="" || $nom=="" || $costo=="" || $precio=="" || $desc=="" || $cat=="" || $id==""){
		header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=No se han llenado todos los campos");
	}else{
		$verificar=$mysqli->query("select * from productos where clave='".$clave."'")or die($mysqli->error);
		if(mysqli_num_rows($verificar)==0){
			header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=No se ha seleccionado producto para modificar");
		}else{
			$r = $mysqli->query("update productos set clave = '$clave', producto = '$nom', costo = '$costo', precio = $precio, stock = $stock, descripcion = '$desc', categoria = '$cat' where idProducto = '".$id."'")or die("ERROR: " .$mysqli->error);
			header("Location: ../inventario.php?id=".$clave."&mesa=0&clave=$id&mensaje=Producto modificado");
		}
	}
	}else{
		//header("Location: ../registro.php?error=Campos Vacios" );
	}
 ?>
