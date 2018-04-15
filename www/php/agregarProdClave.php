<?php
	include 'conexion.php';
	$prod=$_POST['clave'];
	$mesa=$_POST['mesa'];
	if(isset($_POST['clave'])&&isset($_POST['mesa'])){
		if($mesa=="" && $prod=="" || $mesa=="0"){
			header("Location: ../ordenes.php?error=No se ha seleccionado orden&id=0&clave=0&mesa=0");
		}else{
			$getProd = $mysqli->query("select * from productos, detalle_orden where productos.clave='".$prod."' and detalle_orden.idOrden=".$mesa." and productos.idProducto=detalle_orden.idProducto")or die($mysqli->error);
			if(mysqli_num_rows($getProd)==0){
				$getProd2 = $mysqli->query("select * from productos where clave='".$prod."'")or die($mysqli->error);
				if($registro=mysqli_fetch_array($getProd2)){
					$mysqli->query("insert into detalle_orden values(0,".$mesa.",".$registro['idProducto'].",1,".$registro['precio'].",".$registro['precio'].")")or die(header("Location: ../ordenes.php?clave=0&id=0&mesa=0&errorp=qwe"));
					header("Location: ../ordenes.php?clave=".$registro['idProducto']."&id=".$prod."&mesa=".$mesa);
				}else{
					header("Location: ../ordenes.php?clave=0&id=0&mesa=".$mesa."&error=El producto no existe");
				}
			}else{
				$getId = $mysqli->query("select * from productos where clave='".$prod."'")or die($mysqli->error);
				if($cachado=mysqli_fetch_array($getId)){
					$mysqli->query("update detalle_orden set cantidad=cantidad+1, subtotal=cantidad*precioUnitario where idOrden=".$mesa." and idProducto=".$cachado['idProducto'])or die(header("Location: ../ordenes.php?clave=0&id=0&mesa=0&errorp=qwe"));
					header("Location: ../ordenes.php?clave=".$cachado['idProducto']."&id=".$prod."&mesa=".$mesa);
				}else{
					header("Location: ../ordenes.php?clave=0&id=0&mesa=".$mesa."&error=El producto no existe");
				}
			}
		}
	}
?>
