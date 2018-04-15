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
	<link rel="stylesheet" href="./css/styles.css"/>
  <link rel="stylesheet" href="./css/demo.css"/>
</head>
<body>
	<?php
		include "./includes/div.php";
	?>
	<div class="izq">
		<div class="logo">

		</div>
		<form class="" action="./php/getfechaventas.php" method="post">
			<fieldset>
				<div class="field">
		      <input id="date" style="width:200px;" name="date"/>
		    </div>
			</fieldset>
			<fieldset style="margin-top:20px;">
				<input type="submit" name="button" value="VER"
														style="border:1px solid #212121;
														background-color: transparent;
														padding-top:4px;
														padding-bottom:4px;
														height: 40px;" onmouseover="mouseOver('Ver ventas por fecha')" onmouseout="mouseOut()""></input>
			</fieldset>
		</form>
		<div>
			<ul id="menu">
				<?php
					include './php/conexion.php';
					$result=$mysqli->query("SELECT distinct idOrden FROM ventas where fecha = '".$_GET['fecha']."'")or die($mysqli->error);
					while ($ventas= mysqli_fetch_array($result)) {
						echo "<li style='margin-left: 30%;font-weight: bold;'><a href='ventas.php?fecha=".$_GET['fecha']."&id=".$ventas['idOrden']."' name='".$ventas['idOrden']."'>Orden ".$ventas['idOrden']."</a>";
						echo "</li>";
					}
				?>
			</ul>
		</div>
	</div>
	<nav id="header">
	  <ul>
	    <li><a href="./ordenes.php?id=0&clave=0&mesa=0">Órdenes</a></li>
	    <li><a id="link1" href="./inventario.php?id=0&clave=0&mesa=0">Inventario</a></li>
	    <li style="background-color: #212121; height: 25px;padding-top:5px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-left: -5px;"><a id="link2" href="" style="font-weight: bold; color: white;">Ventas</a></li>
	    <li><a id="link3" href="./cortes.php?fecha=0">Corte</a></li>
	    <li><a id="link4" href="./usuarios.php?id=0">Personal</a></li>
	    <li><a href="" id="mostrarSesion" onmouseover="show()"><?php echo $arregloUsuario['Nombre']; ?></a></li>
	  </ul>
		<?php
			include './includes/sesion.php';
		?>
	</nav>
	<div class="miniheader" style="background-color: #212121; height: 180px; margin-top: -120px;">
    <p>ver detalle de órdenes cobradas en el día</p>
	</div>
	<div id="container">
    <button id="btnCobrar" onmouseover="mouseOver('Hacer corte')" onmouseout="mouseOut()">CORTE</button>
		<div id="cobrar" style="top: 20px; height:100px;">
			<button id="cerrarCobrar">
				<i class="fa fa-times"></i>
			</button>
			<h4>Hacer Corte</h4>
			<form action="./cortes.php" method="GET">
				<fieldset>
					<?php
						$fecha=date("Y_m_d");
						echo "<input type='hidden' name='fecha' value='$fecha'>";
					?>
				</fieldset>
				<fieldset>
					<button style="margin-top:20px; margin-left: 30%;background-color:green;" type="submit" class="btn">Corte</button>
				</fieldset>
			</form>
		</div>
		<button id="btnCancelar" onmouseover="mouseOver('Cancelar Venta')" onmouseout="mouseOut()">CANCELAR</button>
		<div id="cancelar" style="top: 20px;">
			<button id="cerrarCancelar">
				<i class="fa fa-times"></i>
			</button>
			<h4>Desea cancelar la orden <?php
			$mesaCancelar=$mysqli->query("select * from ventas where idOrden=".$_GET['id'])or die($mysqli->error);
			if($mostrarMesa=mysqli_fetch_array($mesaCancelar)){
				echo $mostrarMesa['idOrden']."?";
			}
			?></h4>
			<form action="./php/borrarVenta.php" method="POST">
				<fieldset style="display: none;">
					<input type="text" name="borrar" value=<?php echo $_GET['id'];?>>
				</fieldset>
				<fieldset style="display: none;">
					<input type="text" name="fecha" value=<?php echo $_GET['fecha'];?>>
				</fieldset>
				<fieldset>
					<button style="margin-top:20px; margin-left: 43%;background-color:red;" type="submit" class="btn">Cancelar</button>
				</fieldset>
			</form>
		</div>
		<button id="btnEnviar" onmouseover="mouseOver('Imprimir Venta')" onmouseout="mouseOut()">Imprimir</button>
		<div id="imprimir" style="top: 20px;">
			<button id="cerrarImprimir">
				<i class="fa fa-times"></i>
			</button>
			<h4>Desea imprimir el ticket?</h4>
			<form action="./php/imprimirVenta.php" method="POST">
				<fieldset style="display: none;">
					<input type="text" name="id" value=<?php echo $_GET['id'];?>>
				</fieldset>
				<fieldset>
					<button style="margin-top:20px; margin-left: 43%;background-color:blue;" type="submit" class="btn">Imprimir</button>
				</fieldset>
			</form>
		</div>
		<hr>
		<?php
			$datos=$mysqli->query("select * from ventas, referencia where ventas.idOrden =".$_GET['id']." and referencia.idRef = ".$_GET['id'])or die($mysqli->error);
			while($mostrar=mysqli_fetch_array($datos)){
				$total=$mysqli->query("select sum(total) as total2 from ventas where idOrden=".$_GET['id'])or die($mysqli->error());
				echo "<div id='mostrarDatos'><label class='labels' style='margin-top: -260px; font-weight: bold; margin-left: 30px;'>Orden</label>
						<label class='labels' style='margin-top: -240px; font-size: 15px; margin-left: 40px;'>".$mostrar['idOrden']."</label>
						<label class='labels' style='margin-top: -205px; font-weight: bold; margin-left: 30px;'>Mesa</label>
						<label class='labels' style='margin-top: -180px; font-size: 15px; margin-left: 40px;'>".$mostrar['mesa']."</label>
						<label class='labels' style='margin-top: -150px; font-weight: bold; margin-left: 30px;'>Mesero</label>
						<label class='labels' style='margin-top: -125px; font-size: 15px; margin-left: 40px;'>".$mostrar['mesero']."</label>
						<label class='labels' style='margin-top: -95px; font-weight: bold; margin-left: 30px;'>Referencia</label>
						<label class='labels' style='margin-top: -70px; font-size: 15px; margin-left: 40px;'>".$mostrar['referencia']."</label>
						<label class='labels' style='margin-top: 5px; font-weight: bold; margin-left: 30px;'>Total</label>";
					if($existe=mysqli_fetch_array($total)){
						echo "<label class='labels' style='margin-top: 25px; font-size: 15px; margin-left: 40px;'>".$existe['total2']."</label>
						</div>";
					}
			}
		?>
		<div id="tabla">
			<table class="flat-table">
			  <tbody>
			    <tr>
			      <th>Código</th>
			      <th>Producto</th>
			      <th>Precio</th>
			      <th>Cantidad</th>
			      <th>Subtotal</th>
			    </tr>
			    <?php
			    	$detalle=$mysqli->query("select * from ventas, productos where ventas.claveProducto = productos.idProducto and ventas.idOrden=".$_GET['id'])or die($mysqli->error);
			    	while($productos=mysqli_fetch_array($detalle)){
			    		echo "<tr onclick='alert(this.getElementsByTagName('td')[0].innerHTML);alert(this.innerHTML);'>
							      <td>".$productos['clave']."</td>
							      <td>".$productos['producto']."</td>
							      <td>".$productos['precio']."</td>
							      <td>".$productos['cantidad']."</td>
							      <td>".$productos['subtotal']."</td>
							  </tr>";
			    	}

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
	<script type="text/javascript">
	var si=false;
	window.addEventListener('load',function (argument) {
	  document.getElementById("btnCancelar").addEventListener('click',function(){
	  var div=document.getElementById('cancelar');
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
	document.getElementById("cerrarCancelar").addEventListener('click',function(){
	  var div=document.getElementById('cancelar');
	  div.className ="";
	  si=false;
	  div.style.display="none";
	});
	});
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

<script src="./js/datepicker.js"></script>
  <script>
      var input = document.querySelector('input[name="date"]');
      var picker = datepicker(input);
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
