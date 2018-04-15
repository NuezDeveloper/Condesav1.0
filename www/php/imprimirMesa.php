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
			header("Location: ../ordenes.php?error=No hay orden para imprimir&id=0&clave=0&mesa=$id");
		}else{
			$nombre_impresora = "POS58";
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			$detalle=$mysqli->query("select productos.*,detalle_orden.* from productos,detalle_orden where productos.idProducto=detalle_orden.idProducto and detalle_orden.idOrden=".$_POST['id'])or die($mysqli->error);
			$fecha=$mysqli->query("select * from orden, referencia where orden.idOrden = referencia.idRef and orden.idOrden=".$_POST['id'])or die($mysqli->error);
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->feed();
			$printer->text("Orden no. $id");
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
				$cant=$productos['cantidad'];
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$printer->text("$prod");
				$printer->feed();
				$printer->text("Cantidad:   $cant");
				$printer->feed();
				$printer->feed();
			}
			$printer->feed();
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->feed();
			$printer->text("LA CONDESA");
			$printer->feed(5);
			$printer->cut();

			$printer->pulse();

			$printer->close();

			//$mysqli->query("delete from detalle_orden where idOrden=".$id)or die($mysqli->error);
			//$mysqli->query("delete from orden where idOrden=".$id)or die($mysqli->error);
			header("Location: ../ordenes.php?id=0&clave=0&mesa=$id");
		}
	}
?>
