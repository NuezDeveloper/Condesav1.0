<?php
session_start();
	if(isset($_SESSION['secret'])){
		$arregloUsuario=$_SESSION['secret'];
	}else{
		//no hay session
		header("Location: ./login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>La Condesa</title>
	<link rel="stylesheet" href="./css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./css/listas.css">
  <link rel="stylesheet" href="./css/demo.css"/>
  <link rel="stylesheet" href="./css/styles.css"/>
</head>
<body>
	<?php
		include "./includes/div.php";
	?>
	<div class="izq">
		<div class="logo">

		</div>
		<form class="" action="./php/getfecha.php" method="post">
			<fieldset>
				<div class="field">
		      <input id="date" style="width:200px;" value="" name="date"/>
		    </div>
			</fieldset>
			<fieldset style="margin-top:20px;">
				<input type="submit" name="button" value="VER"
														style="border:1px solid #212121;
														background-color: transparent;
														padding-top:4px;
														padding-bottom:4px;
														height: 40px;" onmouseover="mouseOver('Ver corte')" onmouseout="mouseOut()""></input>
			</fieldset>
		</form>
	</div>
	<nav id="header">
	  <ul>
	    <li><a href="./ordenes.php?id=0&clave=0&mesa=0">Órdenes</a></li>
	    <li><a id="link1" href="./inventario.php?id=0&clave=0&mesa=0">Inventario</a></li>
	    <li><a id="link2" href="./ventas.php?id=0&fecha=null">Ventas</a></li>
	    <li style="background-color: #212121; height: 25px;padding-top:5px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-left: -5px;"><a id="link3" href="" style="font-weight: bold; color: white;">Corte</a></li>
	    <li><a id="link4" href="./usuarios.php?id=0">Personal</a></li>
	    <li><a href="" id="mostrarSesion" onmouseover="show()"><?php echo $arregloUsuario['Nombre']; ?></a></li>
	  </ul>
		<?php
			include './includes/sesion.php';
		?>
	</nav>
	<div class="miniheader" style="background-color: #212121; height: 180px; margin-top: -120px;">
		<?php
			include './php/conexion.php';
			$ganancia = $mysqli->query("select (sum(ventas.cantidad*productos.precio) - sum(ventas.cantidad*productos.costo)) as ganancia from ventas, productos where ventas.claveProducto = productos.idProducto and fecha='".$_GET['fecha']."'")or die($mysqli->error);
			if($gan = mysqli_fetch_array($ganancia)){
				echo "<p style='margin-top:11%; margin-left: 57%;'>Ganancia neta: ".$gan['ganancia']."</p>";
			}
		?>
	</div>
	<div id="container">
    <button id="btnCobrar">CORTE</button>
		<div id="cobrar" style="top: 200px;">
			<button id="cerrarCobrar">
				<i class="fa fa-times"></i>
			</button>
			<h4>HACER CORTE</h4>
			<form action="./php/getfecha.php" method="POST">
				<fieldset style="display:none;">
					<input type="text" name="date" value="">
				</fieldset>
				<fieldset>
					<button style="margin-top:20px; margin-left: 30%;background-color:green;" type="submit" class="btn">Corte</button>
				</fieldset>
			</form>
		</div>
		<button id="btnEnviar" onmouseover="mouseOver('Imprimir corte')" onmouseout="mouseOut()">Imprimir</button>
		<div id="imprimir" style="top: 200px;">
			<button id="cerrarImprimir">
				<i class="fa fa-times"></i>
			</button>
			<h4>Desea imprimir el corte?</h4>
			<form action="./php/imprimirCorte.php" method="POST">
				<fieldset style="display: none;">
					<input type="text" name="id" value=<?php echo $_GET['fecha'];?>>
				</fieldset>
				<fieldset>
					<button style="margin-top:20px; margin-left: 35%;background-color:blue;" type="submit" class="btn">Imprimir</button>
				</fieldset>
			</form>
		</div>
		<hr>
		<?php
				include './php/conexion.php';
				$total=$mysqli->query("select sum(total) as totalfinal from ventas where fecha='".$_GET['fecha']."'")or die($mysqli->error());
				if($existe=mysqli_fetch_array($total)){
					echo "<div id='mostrarDatos'>
					<label class='labels' style='margin-top: 0px; font-size: 15px; margin-left: 95px; font-weight:bold;'>Total</label>
					<label id='lbltotal' class='labels' style='margin-top: 20px; font-size: 15px; margin-left: 95px;'>".$existe['totalfinal']."</label>
					</div>";
				}
		?>
		<div id="tabla">
			<table class="flat-table" style="width: 100%;">
				<thead>
					Ventas por Categoría
				</thead>
			  <tbody>
			    <tr>
			      <th style="width: 50%;">Categoría</th>
			      <th style="width: 50%;">Monto</th>
			    </tr>
					<?php

						$r=$mysqli->query("select categorias.*, sum(ventas.total) as total from productos, ventas, categorias where productos.idProducto = ventas.claveProducto and ventas.fecha='".$_GET['fecha']."' and categorias.idCategoria = productos.categoria GROUP by productos.categoria")or die($mysqli->error);
						while($cats=mysqli_fetch_array($r)){
							echo "<tr>
								<td>".$cats['categoria']."</td>
								<td>".$cats['total']."</td>";
						}
						echo "</tr>";
					?>
			  </tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
    var si=false;
    window.addEventListener('load',function (argument) {
      document.getElementById("btnCobrar").addEventListener('click',function(){
      var div=document.getElementById('cobrar');
      if(si){
        div.className ="";
        si=false;
        div.style.display="none";
      }else{
        div.style.display="block";
        div.className +="iniciar";
        si=true;
      }
    });
    document.getElementById("cerrarCobrar").addEventListener('click',function(){
      var div=document.getElementById('cobrar');
      div.className ="";
      si=false;
      div.style.display="none";
    });
    });
 </script>
<script src="./js/datepicker.js"></script>
  <script>
      var input = document.querySelector('input[name="date"]');
      var picker = datepicker(input);
  </script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnEnviar").addEventListener('click',function(){
			var div=document.getElementById('imprimir');
			if(si){
				div.className ="";
				si=false;
				div.style.display="none";
			}else{
				div.style.display="block";
				div.className +="iniciar";
				si=true;
			}
		});
		document.getElementById("cerrarImprimir").addEventListener('click',function(){
			var div=document.getElementById('imprimir');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
<script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="./js/sesion.js"></script>
<script type='text/javascript'>
function nvl(nivel){
	if(nivel == '1'){
		document.getElementById('link1').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
		document.getElementById('link2').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
		document.getElementById('link3').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
		document.getElementById('link4').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
	}else if(nivel == '2'){
		document.getElementById('link1').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
		document.getElementById('link2').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
		document.getElementById('link4').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
	}else if(nivel == '3'){
		document.getElementById('link4').href = window.location+'&error=No se te permite operar está opción, consulta al administrador.';
	}else{

	}
};
nvl(<?php echo $arregloUsuario["Permiso"]; ?>);</script>
</script>
</body>
</html>
