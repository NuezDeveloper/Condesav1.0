<?php
	include 'conexion.php';
	$prod=$_POST['producto2'];
	$mesa=$_POST['mesa2'];
	if(isset($_POST['producto2'])&&isset($_POST['mesa2'])){
		if($mesa=="" && $prod=="" || $mesa=="0" || $prod=="0"){
			header("Location: ../ordenes.php?error=Campos Vacios&id=0&clave=0&mesa=0");
		}else{
			$getProd = $mysqli->query("select * from productos, detalle_orden where productos.idProducto=".$prod." and detalle_orden.idProducto=".$prod." and detalle_orden.idOrden=".$mesa)or die($mysqli->error);
			if(mysqli_num_rows($getProd)==0){
				header("Location: ../ordenes.php?id=0&clave=".$prod."&mesa=".$mesa);
			}else{
				if($re=mysqli_fetch_array($getProd)){
					if($re['cantidad']==1){
						$mysqli->query("delete from detalle_orden where idProducto=".$prod." and idOrden=".$mesa)or die($mysqli->error);
						header("Location: ../ordenes.php?id=".$re['clave']."&clave=".$prod."&mesa=".$mesa);
					}else{
						$mysqli->query("update detalle_orden set cantidad=cantidad-1, subtotal=cantidad*precioUnitario where idOrden=".$mesa." and idProducto=".$prod)or die($mysqli->error);
						header("Location: ../ordenes.php?id=".$re['clave']."&clave=".$prod."&mesa=".$mesa);
					}
				}
			}
		}
	}
?>
