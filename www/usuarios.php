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
	<title>Usuarios</title>
	<link rel="stylesheet" href="./css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./css/listas.css">
</head>
<body>
	<?php
		include "./includes/div.php";
	?>
	<div class="izq">
		<div class="logo">

		</div>
		<form class="" action="./php/buscaremp.php" method="POST">
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
					$result=$mysqli->query("SELECT * FROM puestos")or die($mysqli->error);
					//a partir de acá comienza a imprimir en pantalla

					while ($categorias= mysqli_fetch_array($result)) {
						$cat1=$categorias['idPuesto'];
						//imprime el nombre de la categoria
						echo "<li><input type='checkbox' name='list' id='nivel1-".$categorias['idPuesto']."'><label for='nivel1-".$categorias['idPuesto']."'>".$categorias['puesto']."</label>";
						//obtiene los nombres de las subcategorias pertenecientes a esa categoria
						$result2 = $mysqli->query("SELECT * FROM empleados WHERE puesto LIKE '%$cat1%'") or die($mysqli->error);
						//mientras haya registros los imprime
						while ($subcat = mysqli_fetch_array($result2)) {
							echo "<ul class='interior'>
											<li><a href='usuarios.php?id=".$subcat['idEmpleado']." 'name='".$subcat['idEmpleado']."'>".$subcat['nombre']."</a>
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
	    <li><a id="link1" href="./inventario.php?id=0&clave=0&mesa=0">Inventario</a></li>
	    <li><a id="link2" href="./ventas.php?id=0&fecha=null">Ventas</a></li>
	    <li><a id="link3" href="./cortes.php?fecha=0">Corte</a></li>
	    <li style="background-color: #212121; height: 25px;padding-top:5px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-left: -5px;"><a id="link4" href="#" style="font-weight: bold; color: white;">Personal</a></li>
	    <li><a href="" id="mostrarSesion" onmouseover="show()"><?php echo $arregloUsuario['Nombre']; ?></a></li>
	  </ul>
		<?php
			include './includes/sesion.php';
		?>
	</nav>
	<div class="miniheader" style="background-color: #212121; height: 180px; margin-top: -120px;">
		<?php
			$usuarios = $mysqli->query("SELECT * FROM empleados where idEmpleado = ".$_GET['id']) or die($mysqli->error);
			if($users = mysqli_fetch_array($usuarios)){
				echo "<p style='margin-left:20px;font-size:18px;'>".$users['nombre']."<br>".$users['apellidoPaterno']." ".$users['apellidoMaterno']."</p>";
				echo "<p style='margin-left:220px;'><b>Domicilio</b><br>".$users['domicilio']."</p>";
				echo "<p><b>Teléfono</b><br>".$users['telefono']."</p>";
			}
		?>
	</div>
	<div id="container">
		<?php
			$getimg = $mysqli->query("select * from empleados where idEmpleado=".$_GET['id'])or die($mysqli->error);
			if($r=mysqli_fetch_array($getimg)){
				echo "<img src='./img/".$r['foto']."''>";
			}
		?>
		<button id="refresh" onmouseover="mouseOver('Modificar')" onmouseout="mouseOut()" style="border: none;background-color: gray;position: absolute;height: 50px;width: 50px;background-image: none;right: 60px;">
			<div class="" style="background-image: url(./img/reload2.png);height: 32px;width: 33px; margin-left: 10%;">

			</div>
		</button>
		<button id="delete" onmouseover="mouseOver('Eliminar')" onmouseout="mouseOut()" style="border: none;background-color: gray;position: absolute;height: 50px;width: 50px;background-image: none;right: 60px;top:320px;">
			<div class="" style="background-image: url(./img/delete.png);height: 24px;width: 24px; margin-left: 20%;">

			</div>
		</button>

		<div id="alertadelete">
			<button id="cerrarDel">
				<i class="fa fa-times"></i>
			</button>
			<button type="button" class="btnusuarios" style="margin-top: 5%;margin-left: 35%;" id="btndelp" name="button">Personal</button>
			<button type="button" class="btnusuarios" style="margin-top: 5%;margin-left: 35%;" id="btndelu" name="button">Usuario</button>
			<button type="button" class="btnusuarios" style="margin-top: 5%;margin-left: 35%;" id="btndelpu" name="button">Puesto</button>
		</div>

		<div id="alertadelusu">
			<button id="cerrardelusu">
				<i class="fa fa-times"></i>
			</button>

			<h4>Eliminar Usuario</h4>
			<form action="./php/eliminarusu.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<label>Usuario</label><br>
					<select class="" name="id" style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>
						<?php
							$puestos = $mysqli->query("SELECT * from usuarios")or die($mysqli->error);
							while($true=mysqli_fetch_array($puestos)){
								echo "<option value='".$true['idUsuario']."'>".$true['nombre']."</option>";
							}
						?>
					</select>
				</fieldset>
				<fieldset>
					<button type="submit" class="btn">Eliminar</button>
				</fieldset>
			</form>
		</div>

		<div id="alertadelemp">
			<button id="cerrardelemp">
				<i class="fa fa-times"></i>
			</button>

			<h4>Eliminar Personal</h4>
			<form action="./php/eliminarpersonal.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<label>Personal</label><br>
					<select class="" name="id" style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>
						<?php
							$puestos = $mysqli->query("SELECT * from empleados")or die($mysqli->error);
							while($true=mysqli_fetch_array($puestos)){
								echo "<option value='".$true['idEmpleado']."'>".$true['nombre']."</option>";
							}
						?>
					</select>
				</fieldset>
				<fieldset>
					<button type="submit" class="btn">Eliminar</button>
				</fieldset>
			</form>
		</div>

		<div id="alertadelpuesto">
			<button id="cerrardelpuesto">
				<i class="fa fa-times"></i>
			</button>

			<h4>Eliminar Puesto</h4>
			<form action="./php/eliminarpuesto.php" method="POST" enctype="multipart/form-data">
				<fieldset>
					<label>Puesto</label><br>
					<select class="" name="id" style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>
						<?php
							$puestos = $mysqli->query("SELECT * from puestos")or die($mysqli->error);
							while($true=mysqli_fetch_array($puestos)){
								echo "<option value='".$true['idPuesto']."'>".$true['puesto']."</option>";
							}
						?>
					</select>
				</fieldset>
				<fieldset>
					<button type="submit" class="btn">Eliminar</button>
				</fieldset>
			</form>
		</div>

		<div id="modificar">
			<button id="cerrarMod">
				<i class="fa fa-times"></i>
			</button>
			<button type="button" class="btnusuarios" style="margin-top: 5%;margin-left: 35%;" id="btnmodp" name="button">Personal</button>
			<button type="button" class="btnusuarios" style="margin-top: 5%;margin-left: 35%;" id="btnmodu" name="button">Usuario</button>
			<button type="button" class="btnusuarios" style="margin-top: 5%;margin-left: 35%;" id="btnmodpu" name="button">Puesto</button>
		</div>
	</div>
	<div id="alertausu">
		<button id="cerrarusu">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar Usuario</h4>
		<form action="./php/agregarusuario.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Usuario</label><br>
				<input type="text" name="user" value="">
			</fieldset>
			<fieldset>
				<label>Contraseña</label><br>
				<input type="password" name="pass">
			</fieldset>
			<fieldset>
				<label>Confirmar Contraseña</label><br>
				<input type="password" name="cpass">
			</fieldset>
			<fieldset>
				<label>Permisos</label><br>
				<select name="permiso" style="font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;">
					<option value="1">Básico: Solo manejo de ventas</option>
					<option value="2">Intermedio: Ejecutar corte</option>
					<option value="3">Encargado: Control de inventario</option>
					<option value="4">Administrador: Agregar personal pero no usuarios</option>
					<option value="5">Master: Todos los permisos</option>
				</select>
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Agregar</button>
			</fieldset>
		</form>
	</div>

	<div id="alertaemp">
		<button id="cerraremp">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar Empleado</h4>
		<form action="./php/agregarempleado.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Nombre</label><br>
				<input type="text" name="nom" >
			</fieldset>
			<fieldset>
				<label>Apellido Paterno</label><br>
				<input type="text" name="ap" >
			</fieldset>
			<fieldset>
				<label>Apellido Materno</label><br>
				<input type="text" name="am" >
			</fieldset>
			<fieldset>
				<label>Domicilio</label><br>
				<input type="text" name="dom" >
			</fieldset>
			<fieldset>
				<label>Teléfono</label><br>
				<input type="number" name="tel">
			</fieldset>
			<fieldset>
				<label>Puesto</label><br>
				<select class="" name="puesto" style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>
					<?php
						$puestos = $mysqli->query("SELECT * from puestos")or die($mysqli->error);
						while($true=mysqli_fetch_array($puestos)){
							echo "<option value='".$true['idPuesto']."'>".$true['puesto']."</option>";
						}
					?>
				</select>
			</fieldset>
			<fieldset>
				<label>Foto</label><br>
				<input type="file" name="foto">
			</fieldset>
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Insertar</button>
			</fieldset>
		</form>
	</div>

	<div id="alertapuesto">
		<button id="cerrarpuesto">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar Nuevo Puesto</h4>
		<form action="./php/insPuesto.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label>Puesto</label><br>
				<input type="text" name="puesto" >
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Insertar</button>
			</fieldset>
		</form>
	</div>

	<div id="alertausum">
		<button id="cerrarusum">
			<i class="fa fa-times"></i>
		</button>

		<h4>Modificar Usuario</h4>
		<form action="./php/modificarusu.php" method="POST" enctype="multipart/form-data">
			<fieldset>
			<select id="setname" onchange="setnombre()" class="" style="font-size:20px;padding: 5px 8px;width: 100%;height:35px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;text-align:center;" name="iduser">
				<?php
					$usuarios = $mysqli->query("Select * from usuarios")or die($mysqli->error);
					while($usuariosreg = mysqli_fetch_array($usuarios)){
						echo "<option value='".$usuariosreg['idUsuario']."'>".$usuariosreg['nombre']."</option>";
					}
				?>
			</select>
			</fieldset>
			<fieldset>
				<label>Usuario</label><br>
				<input type="text" name="user" value="" id="getname">
			</fieldset>
			<fieldset>
				<label>Contraseña Anterior</label><br>
				<input type="password" name="passlast">
			</fieldset>
			<fieldset>
				<label>Contraseña Nueva</label><br>
				<input type="password" name="pass">
			</fieldset>
			<fieldset>
				<label>Confirmar Contraseña</label><br>
				<input type="password" name="cpass">
			</fieldset>
			<fieldset>
				<label>Permisos</label><br>
				<select name="permiso" style="font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;">
					<option value="1">Básico: Solo manejo de ventas</option>
					<option value="2">Intermedio: Ejecutar corte</option>
					<option value="3">Encargado: Control de inventario</option>
					<option value="4">Administrador: Agregar personal pero no usuarios</option>
					<option value="5">Master: Todos los permisos</option>
				</select>
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Modificar</button>
			</fieldset>
		</form>
	</div>

	<div id="alertaempm">
		<button id="cerrarempm">
			<i class="fa fa-times"></i>
		</button>

		<h4>Modificar Personal</h4>
		<form action="./php/modificarempleado.php" method="POST" enctype="multipart/form-data">
			<?php
				$personal = $mysqli->query("select * from empleados where idEmpleado = ".$_GET['id'])or die($mysqli->error);
				if($_GET['id']=='0'){
					echo "Por favor selecciona personal para modificar";
				}else{
					while($reg=mysqli_fetch_array($personal)){
					echo "<fieldset>
									<input type='hidden' name='id' value=".$reg['idEmpleado']." >
								</fieldset>
								<fieldset>
									<label>Nombre</label><br>
									<input type='text' name='nom' value='".$reg['nombre']."' >
								</fieldset>
								<fieldset>
									<label>Apellido Paterno</label><br>
									<input type='text' name='ap' value='".$reg['apellidoPaterno']."' >
								</fieldset>
								<fieldset>
									<label>Apellido Materno</label><br>
									<input type='text' name='am' value='".$reg['apellidoMaterno']."' >
								</fieldset>
								<fieldset>
									<label>Domicilio</label><br>
									<input type='text' name='dom' value='".$reg['domicilio']."' >
								</fieldset>
								<fieldset>
									<label>Teléfono</label><br>
									<input type='number' name='tel' value=".$reg['telefono']." >
								</fieldset>
								<fieldset>
									<label>Puesto</label><br>
									<select name='puesto' style='font-size:20px;padding: 5px 8px;width: 100%;height:30px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;'>";
									$puestos = $mysqli->query("SELECT * from puestos")or die($mysqli->error);
									while($true=mysqli_fetch_array($puestos)){
										echo "<option value='".$true['puesto']."'>".$true['puesto']."</option>";
									}
									echo "</select>
								</fieldset>
								<fieldset>
									<label>Foto</label><br>
									<input type='file' name='foto' value=".$reg['foto'].">
								</fieldset>
								</fieldset>
								<fieldset>
									<button type='submit' class='btn'>Insertar</button>
								</fieldset>";
				}
			}
			?>

		</form>
	</div>

	<div id="alertapuestom">
		<button id="cerrarpuestom">
			<i class="fa fa-times"></i>
		</button>

		<h4>Modificar Puesto</h4>
		<form action="./php/modificarpuesto.php" method="POST" enctype="multipart/form-data">
			<fieldset>
			<select class="" style="font-size:20px;padding: 5px 8px;width: 100%;height:35px;border: none;box-shadow: none;background: transparent;background-image: none;-webkit-appearance: none;text-align:center;" name="id">
				<?php
					$usuarios = $mysqli->query("Select * from puestos")or die($mysqli->error);
					while($usuariosreg = mysqli_fetch_array($usuarios)){
						echo "<option value='".$usuariosreg['idPuesto']."'>".$usuariosreg['puesto']."</option>";
					}
				?>
			</select>
			</fieldset>
			<fieldset>
				<label>Puesto</label><br>
				<input type="text" name="puesto" >
			</fieldset>
			<fieldset>
				<button type="submit" class="btn">Modificar</button>
			</fieldset>
		</form>
	</div>

	<style media="screen">
	#btnagregarop{
		width: 50px;
		height: 50px;
		color: white;
		position: absolute;
		bottom: 53%;
		right: 130px;
		border-radius: 50%;
		background-color: gray;
		text-align: center;
		font-size: 2rem;
		line-height: 1.7;
		cursor: pointer;
	}
	#refresh{
		width: 50px;
		height: 50px;
		color: white;
		position: absolute;
		bottom: 53%;
		right: 145px;
		background-size: cover;
		border-radius: 50%;
		background-color: gray;
		text-align: center;
		font-size: 2rem;
		line-height: 1.7;
		cursor: pointer;
	}
	#alertaop{
		width: 26%;
    height: 206px;
    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
    background: white;
    left: 60%;
    top: 110px;
    position: absolute;
    z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertaop h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
		margin-left: 30%;
	}
	#alertaop #cerrarop{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}






	#alertadelete{
		width: 26%;
    height: 206px;
    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
    background: white;
    left: 60%;
    top: 110px;
    position: absolute;
    z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertadelete h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
		margin-left: 30%;
	}
	#alertadelete #cerrarDel{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	#alertadelusu{
		width: 26%;
    height: 300px;
    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
    background: white;
    left: 60%;
    top: 110px;
    position: absolute;
    z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertadelusu h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
		margin-left: 10%;
	}
	#alertadelusu #cerrardelusu{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	#alertadelemp{
		width: 26%;
    height: 300px;
    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
    background: white;
    left: 60%;
    top: 110px;
    position: absolute;
    z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertadelemp h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
		margin-left: 10%;
	}
	#alertadelemp #cerrardelemp{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	#alertadelpuesto{
		width: 26%;
    height: 300px;
    box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
    background: white;
    left: 60%;
    top: 110px;
    position: absolute;
    z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertadelpuesto h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
		margin-left: 10%;
	}
	#alertadelpuesto #cerrardelpuesto{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	#btnagregarusu{
	}
	#alertausu{
		width: 40%;
		height: 510px;
		box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
		background: white;
		left: 30%;
		top:150px;
		position: absolute;
		z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertausu h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
	}
	#alertausu #cerrarusu{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	#btnagregarEmpleado{
	}
	#alertaemp{
		width: 40%;
		height: 600px;
		box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
		background: white;
		left: 30%;
		top:150px;
		position: absolute;
		z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertaemp h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;

	}
	#alertaemp #cerraremp{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}
	#btnagregarpuesto{
	}
	#alertapuesto{
		width: 40%;
		height: 300px;
		box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
		background: white;
		left: 30%;
		top:150px;
		position: absolute;
		z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertapuesto h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;

	}
	#alertapuesto #cerrarpuesto{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}
	#alertausum{
		width: 40%;
		min-height: 500px;
		box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
		background: white;
		left: 30%;
		top:150px;
		position: absolute;
		z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertausum h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;
	}
	#alertausum #cerrarusum{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	#btnagregarEmpleado{
	}
	#alertaempm{
		width: 40%;
		height: 600px;
		box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
		background: white;
		left: 30%;
		top:150px;
		position: absolute;
		z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertaempm h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;

	}
	#alertaempm #cerrarempm{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}
	#btnagregarpuesto{
	}
	#alertapuestom{
		width: 40%;
		height: 300px;
		box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
		background: white;
		left: 30%;
		top:150px;
		position: absolute;
		z-index: 12;
		display: none;
	  overflow-y:scroll;
	}
	#alertapuestom h4{
		text-align: center;
		font-size: 1.5rem;
		padding-top: 10px;

	}
	#alertapuestom #cerrarpuestom{
		width: 30px;
		height: 30px;
		background: #ef2c2c;
		color:white;
		border: none;
		display: block;float: right;
		border-radius: 50%;
		margin-right: -10px;
		margin-top: -10px;
		cursor: pointer;
	}

	.btnusuarios{
		margin-top: 5%;
		margin-left: 35%;
		background-color: #1d1d1d;
	}
	.btnusuariosmod{
		margin-top: 5%;
		margin-left: 35%;
		background-color: #1d1d1d;
	}
	</style>
	<div id="btnagregarop" onmouseover="mouseOver('Agregar')" onmouseout="mouseOut()">
	<i class="fa fa-plus"></i>
	</div>
	<div id="alertaop">
		<button id="cerrarop">
			<i class="fa fa-times"></i>
		</button>

		<h4>Agregar</h4>
		<button type="button" id="btnagregarEmpleado" class="btnusuarios" name="button">Empleado</button>
		<button type="button" id="btnagregarusu" class="btnusuarios" name="button">Usuario</button>
		<button type="button" id="btnagregarpuesto" class="btnusuarios" name="button">Puesto</button>
	</div>

	<script type="text/javascript">
		function setnombre(){
			var select = document.getElementById('setname').options[document.getElementById('setname').selectedIndex].text;
			document.getElementById('getname').value = select;
		}
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
			document.getElementById("btnagregarusu").addEventListener('click',function(){
			var div=document.getElementById('alertausu');
			if(si){
				div.className ="";
				si=false;
				div.style.display="none";
			}else{
				div.style.display="block";
				div.className +="iniciar";
				si=true;
				var divop=document.getElementById('alertaop');
				divop.style.display="none";
			}
		});
		document.getElementById("cerrarusu").addEventListener('click',function(){
			var div=document.getElementById('alertausu');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregarEmpleado").addEventListener('click',function(){
			var div=document.getElementById('alertaemp');
			if(si){
				div.className ="";
				si=false;
				div.style.display="none";
			}else{
				div.style.display="block";
				div.className +="iniciar";
				si=true;
				var divop=document.getElementById('alertaop');
				divop.style.display="none";
			}
		});
		document.getElementById("cerraremp").addEventListener('click',function(){
			var div=document.getElementById('alertaemp');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>
	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
			document.getElementById("btnagregarpuesto").addEventListener('click',function(){
			var div=document.getElementById('alertapuesto');
			if(si){
				div.className ="";
				si=false;
				div.style.display="none";
			}else{
				div.style.display="block";
				div.className +="iniciar";
				si=true;
				var divop=document.getElementById('alertaop');
				divop.style.display="none";
			}
		});
		document.getElementById("cerrarpuesto").addEventListener('click',function(){
			var div=document.getElementById('alertapuesto');
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
		document.getElementById("btnmodp").addEventListener('click',function(){
			var div=document.getElementById('alertaempm');
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
		document.getElementById("cerrarempm").addEventListener('click',function(){
			var div=document.getElementById('alertaempm');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btnmodu").addEventListener('click',function(){
			var div=document.getElementById('alertausum');
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
		document.getElementById("cerrarusum").addEventListener('click',function(){
			var div=document.getElementById('alertausum');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btnmodpu").addEventListener('click',function(){
			var div=document.getElementById('alertapuestom');
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
		document.getElementById("cerrarpuestom").addEventListener('click',function(){
			var div=document.getElementById('alertapuestom');
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
			var div=document.getElementById('alertadelete');
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
		document.getElementById("cerrarDel").addEventListener('click',function(){
			var div=document.getElementById('alertadelete');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>



	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btndelp").addEventListener('click',function(){
			var div=document.getElementById('alertadelemp');
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
		document.getElementById("cerrardelemp").addEventListener('click',function(){
			var div=document.getElementById('alertadelemp');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btndelu").addEventListener('click',function(){
			var div=document.getElementById('alertadelusu');
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
		document.getElementById("cerrardelusu").addEventListener('click',function(){
			var div=document.getElementById('alertadelusu');
			div.className ="";
			si=false;
			div.style.display="none";
		});
		});
	</script>

	<script type="text/javascript">
		var si=false;
		window.addEventListener('load',function (argument) {
		document.getElementById("btndelpu").addEventListener('click',function(){
			var div=document.getElementById('alertadelpuesto');
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
		document.getElementById("cerrardelpuesto").addEventListener('click',function(){
			var div=document.getElementById('alertadelpuesto');
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
		}else if(nivel == '4'){
			document.getElementById('btnagregarusu').style.display = "none";
			document.getElementById('btnmodu').style.display = "none";
			document.getElementById('btndelu').style.display = "none";
			//window.location+'&error=No se te permite operar está opción, consulta al administrador.';
		}else{

		}
	};
	nvl(<?php echo $arregloUsuario["Permiso"]; ?>);</script>
	</script>
</body>
</html>
