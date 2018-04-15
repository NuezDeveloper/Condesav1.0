<?php
include 'conexion.php';
$mesa=$_POST['mesa'];
$mesero=$_POST['mesero'];
$ref=$_POST['referencia'];
if(isset($_POST['mesa']) && isset($_POST['mesero']) && isset($_POST['referencia'])){
	if($mesa=="" || $mesero=="" || $ref==""){
		header("Location: ../ordenes.php?id=0&clave=0&mesa=0&error=No se han llenado los campos");
	}else{
		$mysqli->query("insert into referencia values(0,'$mesa','$mesero','$ref','pendiente')")or die("ERROR: " .$mysqli->error);
		$mysqli->query("insert into orden values(0,".$mysqli->insert_id.",CURDATE(),CURTIME())")or die("ERROR: " .$mysqli->error);
		header("Location: ../ordenes.php?id=0&clave=0&mesa=".$mysqli->insert_id);
	}
}else{
	//header("Location: ../registro.php?error=Campos Vacios" );
}
 ?>
