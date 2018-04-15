<?php
	include 'conexion.php';
	require __DIR__ . '/ticket/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\EscposImage;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	$id=$_POST['id'];
	if(isset($_POST['id'])){
		if($id==""||$id=="0"){
      header("Location: ../cortes.php?error=No se pudo ejecutar el corte&fecha=".$_POST['id']);
		}else{
			$nombre_impresora = "POS58";
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			$detalle=$mysqli->query("select categorias.*, sum(ventas.total) as total from productos, ventas, categorias where productos.idProducto = ventas.claveProducto and ventas.fecha='$id' and categorias.idCategoria = productos.categoria GROUP by productos.categoria")or die($mysqli->error);
			$ganancia = $mysqli->query("select (sum(ventas.cantidad*productos.precio) - sum(ventas.cantidad*productos.costo)) as ganancia from ventas, productos where ventas.claveProducto = productos.idProducto and fecha='$id'")or die($mysqli->error);
			$total=$mysqli->query("select sum(total) as totalfinal from ventas where fecha='$id'")or die($mysqli->error);
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Corte del dia ".$id);
			try{
				//$logo = EscposImage::load("../img/logochico.png");
			  //$printer->graphics($logo);
			}catch(Exception $e){/*No hacemos nada si hay error*/}
			$printer->feed(3);
			while($productos=mysqli_fetch_array($detalle)){
				$prod=$productos['categoria'];
				$pre=$productos['total'];
				$printer->setJustification(Printer::JUSTIFY_RIGHT);
				$printer->text("$prod  ");
				$printer->text("$$pre");
				$printer->feed();
			}
			if($existe=mysqli_fetch_array($total)){
				$final = $existe['totalfinal'];
				$printer->text("Total: $$final");
			}
			$printer->feed(3);
			if($gan = mysqli_fetch_array($ganancia)){
				$g = $gan['ganancia'];
				$printer->setJustification(Printer::JUSTIFY_CENTER);
				$printer->text("Ganancia del dia: $$g");
			}
			$printer->feed(5);
			$printer->cut();

			$printer->pulse();

			$printer->close();

			//$mysqli->query("delete from detalle_orden where idOrden=".$id)or die($mysqli->error);
			//$mysqli->query("delete from orden where idOrden=".$id)or die($mysqli->error);
			header("Location: ../cortes.php?fecha=".$_POST['id']);
		}
	}
?>
