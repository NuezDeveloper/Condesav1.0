<?php
include 'conexion.php';
$cat=$_POST['ing'];
$cant=$_POST['cant'];
$nom=$_POST['nom'];
$minimo=$_POST['minimo'];
if(isset($cat)&&isset($nom)&&isset($minimo)){
	if($nom==""){
		header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=No se han llenado los campos");
	}else{
		$mysqli->query("update inventario set ingrediente = '".$nom."', cantidad = '".$cant."',minimo = $minimo where idIngrediente = ".$cat."")or die("ERROR: " .$mysqli->error);
    header("location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Ingrediente modificado");
	}
}
 ?>
