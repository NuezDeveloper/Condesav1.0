<?php
	include 'conexion.php';
	$prod=$_POST['producto'];
	$mesa=$_POST['mesa'];
	if(isset($_POST['producto'])&&isset($_POST['mesa'])){
		if($mesa=="" && $prod=="" || $mesa=="0" || $prod=="0"){
			header("Location: ../ordenes.php?error=Campos Vacios&id=0&clave=0&mesa=0");
		}else{
			$getProd = $mysqli->query("select * from productos, detalle_orden where productos.idProducto=".$prod." and detalle_orden.idProducto=".$prod." and detalle_orden.idOrden=".$mesa)or die($mysqli->error);
			if(mysqli_num_rows($getProd)==0){
				$getProd2 = $mysqli->query("select * from productos where idProducto=".$prod)or die($mysqli->error);
				if($registro=mysqli_fetch_array($getProd2)){
					$mysqli->query("insert into detalle_orden values(0,".$mesa.",".$prod.",1,".$registro['precio'].",".$registro['precio'].")")or die($mysqli->error);
					header("Location: ../ordenes.php?id=".$registro['clave']."&clave=".$prod."&mesa=".$mesa);
				}
			}else{
				$mysqli->query("update detalle_orden set cantidad=cantidad+1, subtotal=cantidad*precioUnitario where idOrden=".$mesa." and idProducto=".$prod)or die($mysqli->error);
				header("Location: ../ordenes.php?id=0&clave=".$prod."&mesa=".$mesa);
			}
		}
	}
?>
