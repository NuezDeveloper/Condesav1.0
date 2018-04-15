<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="./css/stylesheet.css">
</head>
<body>
	<div class="izq">
		<div class="logo">
		</div>
	</div>
	<nav id="header">
		<ul>
			<li style="background-color: #212121; height: 25px;padding-top:5px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-left: 5px;"><a href="" style="font-weight: bold; color: black;">Órdenes</a></li>
			<li><a href="./inventario.php?id=0&clave=0&mesa=0">Inventario</a></li>
			<li><a href="./ventas.php?id=0">Ventas</a></li>
			<li><a href="./cortes.php?fecha=CURDATE()">Corte</a></li>
			<li><a href="">Usuarios</a></li>
			<li><a href="">Sesión</a></li>
		</ul>
	</nav>
	<div class="miniheader" style="background-color: #212121; height: 180px; margin-top: -120px;">
		<div id='ingre'>
			<ul><b>Pizza Personalizada</b></ul>
		</div>
	</div>
	<div id="container">
		<div id="tablasingre">
			<table id="tabla1">
				<tbody>
					<?php
						include './php/conexion.php';
						$cont=0;
						$datos=$mysqli->query("select DISTINCT(ingredientes.ingredientes),productos.* from ingredientes, productos where productos.idProducto=ingredientes.idProducto and productos.categoria='Pizzas' group by ingredientes")or die($mysqli->error);
						while($ingre=mysqli_fetch_array($datos)){
							echo "<tr id='a".$cont++."'>
								<td>".$ingre['ingredientes']."</td>
								<td class='check'><input name='' type='checkbox'></td>
							</tr>";
						}
					?>
				</tbody>
			</table>
			<table id="tabla2">
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
<script>
$(document).ready(function(){
	$('input[type=checkbox]').click(function() {
		if($(this).is(":checked"))
		{
			// el checkbox esta marcado
			// movemos la columna a la tabla2
			var tr=$(this).parents("tr").appendTo("#tabla2 tbody");
		}else{
			// el checkbox esta desmarcado
			// movemos la columna a la tabla1
			var tr=$(this).parents("tr").appendTo("#tabla1 tbody");
		}
	});
});
</script>
