<?php
	include 'conexion.php';
	require __DIR__ . '/ticket/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\EscposImage;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	$id=$_POST['id'];
	$pago=$_POST['txtPagar'];
	$cambio=$_POST['tcambio'];
	if(isset($_POST['id'])){
		if($id==""||$id=="0"){
			header("Location: ../ordenes.php?error=No hay orden para cobrar&id=0&clave=0&mesa=0");
		}else{
			$getProd = $mysqli->query("select *, subtotal*cantidad as total from detalle_orden
			where idOrden=".$id)or die($mysqli->error);
			while($re=mysqli_fetch_array($getProd)){
				$mysqli->query("insert into ventas values(0,".$re['cantidad'].",".$re['idProducto'].",
				CURDATE(),CURTIME(),".$re['idOrden'].",".$re['subtotal'].",".$re['total'].")")or die($mysqli->error);
			}
			$nombre_impresora = "POS58";
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			$detalle=$mysqli->query("select productos.*,detalle_orden.* from productos,detalle_orden where productos.idProducto=detalle_orden.idProducto and detalle_orden.idOrden=".$_POST['id'])or die($mysqli->error);
			$fecha=$mysqli->query("select * from orden, referencia where orden.idOrden = referencia.idRef and orden.idOrden=".$_POST['id'])or die($mysqli->error);
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("LA CONDESA");
			$printer->feed();
			$printer->text("Av. Benito Juarez #412");
			$printer->feed();
			$printer->text("Col. Centro");
			$printer->feed();
			$printer->text("(636)668-11-58");
			if($hora=mysqli_fetch_array($fecha)){
				$datos=$hora['fecha'];
				$printer->feed();
				$data=$hora['hora'];
				$printer->feed();
				$mesero=$hora['mesero'];
				$printer->feed();
				$printer->text("$datos $data");
				$printer->feed();
				$printer->text("Mesero: $mesero");
			}
			try{
				//$logo = EscposImage::load("../img/logochico.png");
			  //$printer->graphics($logo);
			}catch(Exception $e){/*No hacemos nada si hay error*/}
			$printer->feed(2);
			while($productos=mysqli_fetch_array($detalle)){
				$prod=$productos['producto'];
				$pre=$productos['precio'];
				$cant=$productos['cantidad'];
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$printer->text("$prod");
				$printer->feed();
				$printer->text("$cant   x   $pre");
				$printer->feed();
				$printer->feed();
				$dism = $mysqli->query("select * from ingredientes where idProducto = ".$productos['idProducto'])or die($mysqli->error);
				while($enc = mysqli_fetch_array($dism)){
					$i = $enc['ingredientes'];
					$x = $enc['cantidad'];
					$t = $x * $cant;
					$mysqli->query("update inventario set cantidad = cantidad - $t where ingrediente = '".$i."'")or die($mysqli->error);
				}
			}
			$printer->feed();
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$footer=$mysqli->query("select sum(subtotal) as total from detalle_orden where idOrden=".$_POST['id'])or die($mysqli->error);
			if($total=mysqli_fetch_array($footer)){
				$tot=$total['total'];
				$printer->text("Total: $tot");
				$printer->feed();
				$printer->text("Pago con: $pago");
				$printer->feed();
				$printer->text("Su cambio: $cambio");
				$printer->feed();
			}
			$printer->feed();
			$printer->text("GRACIAS POR SU COMPRA");
			$printer->feed();
			$printer->text("LA CONDESA");
			$printer->feed(5);
			$printer->cut();

			$printer->pulse();

			$printer->close();

			$mysqli->query("update referencia set estatus='completa' where idRef=".$id)or die($mysqli->error);
			//$mysqli->query("delete from detalle_orden where idOrden=".$id)or die($mysqli->error);
			//$mysqli->query("delete from orden where idOrden=".$id)or die($mysqli->error);
			header("Location: ../ordenes.php?id=0&clave=0&mesa=0");
		}
	}
?>
