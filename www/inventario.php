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
<head lang="es">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inventario</title>
	<link rel="stylesheet" href="./css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./css/listas.css">
	<?php
		if(isset($_GET['erroring'])){
			printf("<script type='text/javascript'>alert('No seleccionaste ningún producto'); </script>");
		}
		if(isset($_GET['errorproducto'])){
			printf("<script type='text/javascript'>alert('Ya existe un producto con esa clave'); </script>");
		}
	?>
</head>
<body>
	<?php
		include "./includes/div.php";
	?>
	<div class="izq">
		<div class="logo">

		</div>
		<form class="" action="./php/agregarProdClaveinv.php" method="POST">
			<fieldset style="margin-left:-20px;margin-top:-14px;">
				<input type="search" name="clave" placeholder="Buscar">
			</fieldset>
			<fieldset style="display:none;">
				<input type="submit" value="">
			</fieldset>
		</form>
		<div>
			<ul id="menu">
				<?php
					include './php/conexion.php';
					$result=$mysqli->query("SELECT * FROM categorias")or die($mysqli->error);
					//a partir de acá comienza a imprimir en pantalla
					while ($categorias= mysqli_fetch_array($result)) {
						$cat1=$categorias['idCategoria'];
						//imprime el nombre de la categoria
						echo "<li><input type='checkbox' name='list' id='nivel1-".$categorias['idCategoria']."'><label for='nivel1-".$categorias['idCategoria']."'>".$categorias['categoria']."</label>";

						//obtiene los nombres de las subcategorias pertenecientes a esa categoria
						$result2 = $mysqli->query("SELECT * FROM productos WHERE categoria LIKE '%$cat1%'") or die($mysqli->error);
						//mientras haya registros los imprime
						while ($subcat = mysqli_fetch_array($result2)) {
							echo "<ul class='interior'>
											<li><a href='inventario.php?id=".$subcat['clave']."&clave=".$subcat['idProducto']."&mesa=".$_GET['mesa']." 'name='".$subcat['idProducto']."'>".$subcat['producto']."</a>
											</li>
										</ul>";
						}
						echo "</li>";
					}
				?>
			</ul>
		</div>
	</div>
	<nav id="header">
	  <ul>
	    <li><a href="./ordenes.php?id=0&clave=0&mesa=0">Órdenes</a></li>
	    <li style="background-color: #212121; height: 25px;padding-top:5px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-left: -5px;"><a id="link1" href="" style="font-weight: bold; color: white;">Inventario</a></li>
	    <li><a id="link2" href="./ventas.php?id=0&fecha=null">Ventas</a></li>
	    <li><a id="link3" href="./cortes.php?fecha=0">Corte</a></li>
	    <li><a id="link4" href="./usuarios.php?id=0">Personal</a></li>
	    <li><a href="" id="mostrarSesion" onmouseover="show()"><?php echo $arregloUsuario['Nombre']; ?></a></li>
	  </ul>
		<?php
			include './includes/sesion.php';
		?>
	</nav>
	<div class="miniheader" style="background-color: #212121; height: 180px; margin-top: -120px;">
		<?php
		$nombreProd = $mysqli->query("SELECT productos.* FROM productos where idProducto=".$_GET["clave"]) or die($mysqli->error);
		if($registro = mysqli_fetch_array($nombreProd)){
			echo "<label>".$registro['producto']."</label>";
			echo "<p><b>Precio</b><br>$".$registro['precio']."</p>
			";
			echo "<div id='ingre'>";
			echo "<ul><b>Descripción</b>";
			echo "<li style='list-style: none;'>".$registro['descripcion']."</li>";
			echo "</ul>";
			echo "</div>";
		}
		?>
		<a href="./inventario.php?id=0&clave=0&mesa=0">Ver todos los ingredientes</a>
	</div>
	<div id="container">
		<?php
			$getimg = $mysqli->query("select * from categorias, productos where productos.idProducto=".$_GET['clave']." and productos.categoria=categorias.categoria")or die($mysqli->error);
			if($r=mysqli_fetch_array($getimg)){
				echo "<img src='./img/".$r['imagen']."''>";
			}
		?>
		<div style="height: 70px;"></div>
		<hr>
		<style media="screen">
		#btnagregarop{
			width: 50px;
			height: 50px;
			color: white;
			position: absolute;
			top: 250px;
			right: 100px;
			border-radius: 50%;
			background-color: gray;
			text-align: center;
			font-size: 2rem;
			line-height: 1.7;
			cursor: pointer;
		}
		#alertaop{
			width: 20%;
	    min-height: 200px;
	    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
	    background: white;
	    left: 74%;
	    top: 50px;
	    position: absolute;
	    z-index: 12;
	    display: none;
		}
		#alertaop h4{
			text-align: center;
			font-size: 1.5rem;
			padding-top: 10px;
			margin-left: 20%;
		}
		#alertaop #cerrarop{
			width: 25px;
			height: 25px;
			background: #ef2c2c;
			color:white;
			border: none;
			display: block;
			float: right;
			border-radius: 50%;
			margin-right: -10px;
			margin-top: -10px;
			cursor: pointer;
		}
		#alertabp{
			width: 20%;
	    min-height: 200px;
	    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
	    background: white;
	    left: 74%;
	    top: 50px;
	    position: absolute;
	    z-index: 12;
	    display: none;
		}
		#alertabp h4{
			text-align: center;
			font-size: 1.5rem;
			padding-top: 10px;
			margin-left: 20%;
		}
		#alertabp #cerrarbp{
			width: 25px;
			height: 25px;
			background: #ef2c2c;
			color:white;
			border: none;
			display: block;
			float: right;
			border-radius: 50%;
			margin-right: -10px;
			margin-top: -10px;
			cursor: pointer;
		}
		#alertael{
			width: 20%;
	    min-height: 200px;
	    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
	    background: white;
	    left: 74%;
	    top: 50px;
	    position: absolute;
	    z-index: 12;
	    display: none;
		}
		#alertael h4{
			text-align: center;
			font-size: 1.5rem;
			padding-top: 10px;
			margin-left: 20%;
		}
		#alertael #cerrarel{
			width: 25px;
			height: 25px;
			background: #ef2c2c;
			color:white;
			border: none;
			display: block;
			float: right;
			border-radius: 50%;
			margin-right: -10px;
			margin-top: -10px;
			cursor: pointer;
		}

		#alertaIel{
			width: 20%;
			min-height: 200px;
			box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
			background: white;
			left: 74%;
			top: 50px;
			position: absolute;
			z-index: 12;
			display: none;
		}
		#alertaIel h4{
			text-align: center;
			font-size: 1.5rem;
			padding-top: 10px;
			margin-left: 20%;
		}
		#alertaIel #cerrarIel{
			width: 25px;
			height: 25px;
			background: #ef2c2c;
			color:white;
			border: none;
			display: block;
			float: right;
			border-radius: 50%;
			margin-right: -10px;
			margin-top: -10px;
			cursor: pointer;
		}


		#alerta22el{
			width: 20%;
			min-height: 200px;
			box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
			background: white;
			left: 74%;
			top: 50px;
			position: absolute;
			z-index: 12;
			display: none;
		}
		#alerta22el h4{
			text-align: center;
			font-size: 1.5rem;
			padding-top: 10px;
			margin-left: 20%;
		}
		#alerta22el #cerrar22el{
			width: 25px;
			height: 25px;
			background: #ef2c2c;
			color:white;
			border: none;
			display: block;
			float: right;
			border-radius: 50%;
			margin-right: -10px;
			margin-top: -10px;
			cursor: pointer;
		}
		.btninv{
			margin-top: 5%;
			margin-left: 25%;
			background-color: #1d1d1d;
		}
		</style>
		<button id="refresh" onmouseover="mouseOver('Modificar')" onmouseout="mouseOut()"></button>
		<div id="modificar" style="width: 35%; height: 255px; left: 35%;">
			<button id="cerrarMod">
				<i class="fa fa-times"></i>
			</button>

			<h4>Modificar</h4>
			<button id="modificarProducto">Producto</button>
			<div id="panelModProd">
		<button id="cerrarModProd">
			<i class="fa fa-times"></i>
		</button>

		<h4>Modificar Producto</h4>
		<form action="./php/modificarproducto.php" method="POST">
			<?php
				include './php/conexion.php';
				$prd=$mysqli->query("select * from productos where clave = '".$_GET['id']."'")or die($mysqli->error);
				if($_GET['clave']=='0'){
					echo "Selecciona un producto para modificar";
				}else{
					while($e=mysqli_fetch_array($prd)){
						$re=$mysqli->query("select * from categorias;")or die($mysqli->error);
						echo "
						<fieldset>
							<input type='hidden' name='id' value=".$e['idProducto']." >
						</fieldset>
						<fieldset>
							<label>Clave</label><br>
							<input type='text' name='clave' value=".$e['clave']." >
						</fieldset>
						<fieldset>
							<label>Nombre</label><br>
							<input type='text' name='nom' value='".$e['producto']."'>
						</fieldset>
						<fieldset>
							<label>Costo</label><br>
							<input type='number' name='costo' value=".$e['costo'].">
						</fieldset>
						<fieldset>
							<label>Precio</label><br>
							<input type='number' name='precio' value=".$e['precio'].">
						</fieldset>
						<fieldset>
							<label>Descripcion</label><br>
							<input type='text' name='desc' value='".$e['descripcion']."'>
						</fieldset>
						<fieldset>
							<label>Categoria</label><br>
							<select name='cat' style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>";
									while($fila=mysqli_fetch_array($re)){
										echo "<option value='".$fila['categoria']."'>".$fila['categoria']."</option>";
									}
							echo "</select>
						</fieldset>
						<fieldset>
							<button type='submit' class='btn' style='margin-left:265 !important;'>Modificar</button>
						</fieldset>";
					}
				}
			?>
		</form>

	</div>
			<button id="modificarCategoria">Categoría</button>
			<div id="panelModCat">
		<button id="cerrarModCat">
			<i class="fa fa-times"></i>
		</button>
		<h4>Modificar Categoría</h4>
		<form action="./php/modcat.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<select class="" name="cat" style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>
					<?php
						$i=$mysqli->query("SELECT * from categorias")or die($mysqli->error);
						while($sihay=mysqli_fetch_array($i)){
							echo "<option value='".$sihay['categoria']."'>".$sihay['categoria']."</option>";
						}
					?>
				</select>
			</fieldset>
			<fieldset>
				<label>Nombre</label><br>
				<input type="text" name="nom" >
			</fieldset>
			<fieldset>
				<label>Imagen</label><br>
				<input type="file" name="imagen">
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Modificar</button>
			</fieldset>
		</form>
	</div>
	<button type="button" id="btnmodificar" name="button">Ingrediente</button>
		</div>
		<?php
			$datos=$mysqli->query("select * from productos where idProducto=".$_GET['clave'])or die($mysqli->error);
			while($mostrar=mysqli_fetch_array($datos)){
				echo "<div id='mostrarDatos'><label class='labels' style='margin-top: -260px; font-weight: bold; margin-left: 30px;'>Clave</label>
						<label class='labels' style='margin-top: -240px; font-size: 15px; margin-left: 40px;'>".$mostrar['clave']."</label>
						<label class='labels' style='margin-top: -205px; font-weight: bold; margin-left: 30px;'>Costo</label>
						<label class='labels' style='margin-top: -180px; font-size: 15px; margin-left: 40px;'>".$mostrar['costo']."</label>";
			}
		?>
	</div>

	<button id="delete" onmouseover="mouseOver('Eliminar')" onmouseout="mouseOut()" style="border: none;background-color: gray;position: absolute;height: 50px;width: 50px;background-image: none;right: 40px;top: 250px; border-radius: 50%; margin-top: 0px;">
		<div class="" style="background-image: url(./img/delete.png);height: 24px;width: 24px; margin-left: 20%;">

		</div>
	</button>
	<div id="alertabp" style="top: 100px; left: 70%; width: 20%;">
		<button id="cerrarbp">
			<i class="fa fa-times"></i>
		</button>

		<h4>Eliminar</h4>
		<button type="button" id="btnep" class="btninv" style="margin-top: 5%;margin-left: 25%;background-color: #1d1d1d;"	 name="button">Producto</button>
		<button type="button" id="btnec" class="btninv" style="margin-top: 5%;margin-left: 25%;background-color: #1d1d1d;"	 name="button">Categoría</button>
	</div>

	<div id="alerta22el">
		<button id="cerrar22el">
			<i class="fa fa-times"></i>
		</button>

		<h4>Eliminar Categoria</h4>
		<form action="./php/elCat.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Categoria</label><br>
				<select name="id" style="font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;">
					<?php
						include './php/conexion.php';
						$re=$mysqli->query("select * from categorias;")or die($mysqli->error);
						while($fila=mysqli_fetch_array($re)){
							echo "<option value='".$fila['idCategoria']."'>".$fila['categoria']."</option>";
						}
					?>
				</select>
			</fieldset>
			<br>
			<p>NOTA: si elimina una categoría se eliminarán todos los productos existentes en esa categoría</p>
			<fieldset>
				<button type="submit" class="btn">Eliminar</button>
			</fieldset>
		</form>
	</div>

	<div id="alertael">
		<button id="cerrarel">
			<i class="fa fa-times"></i>
		</button>

		<h4>Eliminar Producto</h4>
		<form action="./php/elProd.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Producto</label><br>
				<select name="id" style="font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;">
					<?php
						include './php/conexion.php';
						$re=$mysqli->query("select * from productos;")or die($mysqli->error);
						while($fila=mysqli_fetch_array($re)){
							echo "<option value='".$fila['idProducto']."'>".$fila['producto']."</option>";
						}
					?>
				</select>
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Eliminar</button>
			</fieldset>
		</form>
	</div>

	<div id="btnagregarop" onmouseover="mouseOver('Agregar')" onmouseout="mouseOut()">
	<i class="fa fa-plus"></i>
	</div>
	<div id="alertaop" style="top: 100px; left: 70%; width: 20%;">
		<button id="cerrarop">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar</h4>
		<button type="button" id="btnagregar" class="btninv" style="margin-top: 5%;margin-left: 25%;background-color: #1d1d1d;"	 name="button">Producto</button>
		<button type="button" id="btnagregarCat" class="btninv" style="margin-top: 5%;margin-left: 25%;background-color: #1d1d1d;"	 name="button">Categoría</button>
		<button type="button" id="btnagregarIn" class="btninv" style="margin-top: 5%;margin-left: 25%;background-color: #1d1d1d;"	 name="button">Ingrediente</button>
	</div>

	<div id="alerta22">
		<button id="cerrar22">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar Ingredientes</h4>
		<form action="./php/insIng.php" method="POST" enctype="multipart/form-data">
			<fieldset style="display:none;">
				<label>Ingrediente</label><br>
				<input type="text" name="clave" value=<?php echo $_GET['clave']?>>
			</fieldset>
			<fieldset>
				<label>Ingrediente</label><br>
				<select name="ing" style="font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;">
					<?php
						$re=$mysqli->query("select ingrediente from inventario;")or die($mysqli->error);
						while($fila=mysqli_fetch_array($re)){
							echo "<option value='".$fila['ingrediente']."'>".$fila['ingrediente']."</option>";
						}
					?>
				</select>
			</fieldset>
			<fieldset>
				<label>Cantidad en gramos</label>
				<input type="number" name="cantidad">
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Agregar</button>
			</fieldset>
		</form>
	</div>

	<div id="alerta">
		<button id="cerrar">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar Producto</h4>
		<form action="./php/insProd.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Clave</label><br>
				<input type="text" name="clave" >
			</fieldset>
			<fieldset>
				<label>Nombre</label><br>
				<input type="text" name="nom" >
			</fieldset>
			<fieldset>
				<label>Costo</label><br>
				<input type="number" name="costo" >
			</fieldset>
			<fieldset>
				<label>Precio</label><br>
				<input type="number" name="precio" >
			</fieldset>
			<fieldset>
				<label>Descripcion</label><br>
				<input type="text" name="desc">
			</fieldset>
			<fieldset>
				<label>Categoria</label><br>
				<select name="cat" style="font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;">
					<?php
						include './php/conexion.php';
						$re=$mysqli->query("select * from categorias;")or die($mysqli->error);
						while($fila=mysqli_fetch_array($re)){
							echo "<option value='".$fila['idCategoria']."'>".$fila['categoria']."</option>";
						}
					?>
				</select>
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Insertar</button>
			</fieldset>
		</form>
	</div>

		<div id="alertaI">
			<button id="cerrarI">
				<i class="fa fa-times"></i>
			</button>
			<h4>Agregar ingrediente a inventario</h4>
			<form action="./php/insInv.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<label>Ingrediente</label><br>
					<input type="text" name="ing" >
				</fieldset>
				<fieldset>
					<label>Cantidad en gramos</label>
					<input type="number" name="can">
				</fieldset>
				<fieldset>
					<label>Cantidad mínima</label>
					<input type="number" name="minimo">
				</fieldset>
				<fieldset>
					<button type="submit" class="btn">Insertar</button>
				</fieldset>
			</form>
		</div>

		<div id="alertamod">
			<button id="cerrarmod">
				<i class="fa fa-times"></i>
			</button>
			<h4>Modificar Ingrediente</h4>
			<form action="./php/moding.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<select id="setname" onchange="setnombre()" class="" name="ing" style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>
						<?php
							$i=$mysqli->query("SELECT * from inventario")or die($mysqli->error);
							while($sihay=mysqli_fetch_array($i)){
								echo "<option value='".$sihay['idIngrediente']."'>".$sihay['ingrediente']."</option>";
							}
						?>
					</select>
				</fieldset>
				<fieldset>
					<label>Nombre</label><br>
					<input type="text" name="nom" id="getnombre">
				</fieldset>
				<fieldset>
					<label>Cantidad</label><br>
					<input type="number" name="cant">
				</fieldset>
				<fieldset>
					<label>Cantidad mínima</label>
					<input type="number" name="minimo">
				</fieldset>
				<fieldset>
					<button type="submit" class="btn">Modificar</button>
				</fieldset>
			</form>
		</div>


	<div id="alertaCat">
		<button id="cerrarCat">
			<i class="fa fa-times"></i>
		</button>
		<h4>Agregar Categoría</h4>
		<form action="./php/inscat.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Nombre</label><br>
				<input type="text" name="nom" >
			</fieldset>
			<fieldset>
				<label>Imagen</label><br>
				<input type="file" name="imagen">
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Insertar</button>
			</fieldset>
		</form>
	</div>
	<div id="tabla" style="margin-left:50%;">
		<table class="flat-table">
			<tbody>

				<?php
					if($_GET['clave']==0){
						$detalle=$mysqli->query("select * from inventario")or die($mysqli->error);
						echo "<tr>
										<th>Ingrediente</th>
										<th>Cantidad</th>
										<th>Cantidad mínima</th>
										<th>Eliminar</th>
									</tr>";
						while($productos=mysqli_fetch_array($detalle)){
							echo "<tr onclick='alert(this.getElementsByTagName('td')[0].innerHTML);alert(this.innerHTML);'>
										<td>".$productos['ingrediente']."</td>
										<td>".$productos['cantidad']."gr</td>
										<td>".$productos['minimo']."gr</td>
										<td style='padding:0px;'>
										<form action='./php/borrarIngre.php' method='POST'>
											<fieldset style='display: none;'>
												<input type='text' name='bi' value=".$productos['idIngrediente'].">
											</fieldset>
											<fieldset style='display: none;'>
												<input type='text' name='biip' value='".$productos['ingrediente']."'>
											</fieldset>
											<fieldset style='margin-top: -44px;'>
												<input type='submit' value='' style='height: 20px;
												width: 20px;
												margin-left: 50px;
												margin-top: 35px;
												background-image: url(./img/less.png);
												background-size: cover;
												background-color: transparent;
												border: none;'>
											</fieldset>
										</form></td>
								</tr>";
						}
						echo "<tr>
							<td colspan='4'> <div id='btnagregarI'>
							Agregar
							</div> </td>
						</tr>";
					}else{
						$detalle=$mysqli->query("SELECT * FROM ingredientes where idProducto=".$_GET['clave'])or die($mysqli->error);
						echo "<tr>
										<th>Ingrediente</th>
										<th>Cantidad</th>
										<th>Eliminar</th>
									</tr>";
						while($productos=mysqli_fetch_array($detalle)){
							echo "
										<td>".$productos['ingredientes']."</td>
										<td>".$productos['cantidad']."gr</td>
										<td style='padding:0px;'>
										<form action='./php/borrarIngreProd.php' method='POST'>
											<fieldset style='display: none;'>
												<input type='text' name='biip' value=".$productos['idProducto'].">
											</fieldset>
											<fieldset style='display: none;'>
												<input type='text' name='bi' value=".$productos['ingredientes'].">
											</fieldset>
											<fieldset style='margin-top: 0px;'>
												<input type='submit' value='' style='height: 20px;
												width: 20px;
												margin-left: 50px;
												margin-top: -20px;
												background-image: url(./img/less.png);
												background-size: cover;
												background-color: transparent;
												border: none;'>
											</fieldset>
										</form></td>
								</tr>";
						}
						echo "<tr>
							<td colspan='3'> <div id='btnagregar22'>
							Agregar
							</div> </td>
						</tr>";
					}
				?>

			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		function setnombre(){
			var select = document.getElementById('setname').options[document.getElementById('setname').selectedIndex].text;
			document.getElementById('getnombre').value = select;
		}
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnmodificar").addEventListener('click',function(){
			var div=document.getElementById('alertamod');
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
		document.getElementById("cerrarmod").addEventListener('click',function(){
			var div=document.getElementById('alertamod');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregarIn").addEventListener('click',function(){
			var div=document.getElementById('alertaI');
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
		document.getElementById("cerrarI").addEventListener('click',function(){
			var div=document.getElementById('alertaI');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregarI").addEventListener('click',function(){
			var div=document.getElementById('alertaI');
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
		document.getElementById("cerrarI").addEventListener('click',function(){
			var div=document.getElementById('alertaI');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregar22").addEventListener('click',function(){
			var div=document.getElementById('alerta22');
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
		document.getElementById("cerrar22").addEventListener('click',function(){
			var div=document.getElementById('alerta22');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregar").addEventListener('click',function(){
			var div=document.getElementById('alerta');
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
		document.getElementById("cerrar").addEventListener('click',function(){
			var div=document.getElementById('alerta');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btnagregarCat").addEventListener('click',function(){
			var div=document.getElementById('alertaCat');
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
		document.getElementById("cerrarCat").addEventListener('click',function(){
			var div=document.getElementById('alertaCat');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("refresh").addEventListener('click',function(){
			var div=document.getElementById('modificar');
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
		document.getElementById("cerrarMod").addEventListener('click',function(){
			var div=document.getElementById('modificar');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("modificarProducto").addEventListener('click',function(){
			var div=document.getElementById('panelModProd');
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
		document.getElementById("cerrarModProd").addEventListener('click',function(){
			var div=document.getElementById('panelModProd');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("modificarCategoria").addEventListener('click',function(){
			var div=document.getElementById('panelModCat');
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
		document.getElementById("cerrarModCat").addEventListener('click',function(){
			var div=document.getElementById('panelModCat');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregarop").addEventListener('click',function(){
			var div=document.getElementById('alertaop');
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
		document.getElementById("cerrarop").addEventListener('click',function(){
			var div=document.getElementById('alertaop');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("delete").addEventListener('click',function(){
			var div=document.getElementById('alertabp');
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
		document.getElementById("cerrarbp").addEventListener('click',function(){
			var div=document.getElementById('alertabp');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>



	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btnep").addEventListener('click',function(){
			var div=document.getElementById('alertael');
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
		document.getElementById("cerrarel").addEventListener('click',function(){
			var div=document.getElementById('alertael');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btnei").addEventListener('click',function(){
			var div=document.getElementById('alertaIel');
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
		document.getElementById("cerrarIel").addEventListener('click',function(){
			var div=document.getElementById('alertaIel');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btnec").addEventListener('click',function(){
			var div=document.getElementById('alerta22el');
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
		document.getElementById("cerrar22el").addEventListener('click',function(){
			var div=document.getElementById('alerta22el');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
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
