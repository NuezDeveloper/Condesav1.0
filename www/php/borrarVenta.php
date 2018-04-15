<?php
	include 'conexion.php';
	$orden=$_POST['borrar'];
	$fecha=$_POST['fecha'];
	if(isset($_POST['borrar'])){
		if($orden==""||$orden=="0"){
			header("Location: ../ventas.php?error=No se ha seleccionado venta para eliminar&id=0&fecha=null");
		}else{
			$detalle=$mysqli->query("select productos.*,detalle_orden.* from productos,detalle_orden where productos.idProducto=detalle_orden.idProducto and detalle_orden.idOrden=".$_POST['borrar'])or die($mysqli->error);
			while($productos=mysqli_fetch_array($detalle)){
				$prod=$productos['producto'];
				$pre=$productos['precio'];
				$cant=$productos['cantidad'];
				$dism = $mysqli->query("select * from ingredientes where idProducto = ".$productos['idProducto'])or die($mysqli->error);
				while($enc = mysqli_fetch_array($dism)){
					$i = $enc['ingredientes'];
					$x = $enc['cantidad'];
					$t = $x * $cant;
					$mysqli->query("update inventario set cantidad = cantidad + $t where ingrediente = '".$i."'")or die($mysqli->error);
				}
			}
			$mysqli->query("delete from ventas where idOrden=".$orden)or die($mysqli->error);
  		header("Location: ../ventas.php?id=0&fecha=$fecha&mensaje=Venta cancelada");
		}
	}
?>
