<?php
	include 'conexion.php';
	require __DIR__ . '/ticket/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\EscposImage;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	$id=$_POST['id'];
	if(isset($_POST['id'])){
		if($id==""||$id=="0"){
			$fecha=date("Y_m_d");
			header("Location: ../ventas.php?error=No ha seleccionado venta para imprimir&id=0&fecha=$fecha");
		}else{
			$nombre_impresora = "POS58";
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			$detalle=$mysqli->query("select * from ventas, productos where ventas.claveProducto = productos.idProducto and ventas.idOrden=".$_POST['id'])or die($mysqli->error);
			$fecha=$mysqli->query("select * from ventas, productos, referencia where ventas.claveProducto = productos.idProducto and referencia.idRef=ventas.idOrden and ventas.idOrden=".$_POST['id'])or die($mysqli->error);
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Venta No. $id");
			$printer->feed();
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
			}
			$printer->feed();
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$footer=$mysqli->query("select sum(subtotal) as total from detalle_orden where idOrden=".$_POST['id'])or die($mysqli->error);
			if($total=mysqli_fetch_array($footer)){
				$tot=$total['total'];
				$printer->text("Total: $tot");
				$printer->feed();
			}
			$printer->feed(5);
			$printer->cut();

			$printer->pulse();

			$printer->close();

			//$mysqli->query("delete from detalle_orden where idOrden=".$id)or die($mysqli->error);
			//$mysqli->query("delete from orden where idOrden=".$id)or die($mysqli->error);
			header("Location: ../ventas.php?id=0&fecha=null");
		}
	}
?>
