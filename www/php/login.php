<?php
session_start();
include 'conexion.php';
if(isset($_POST['nom']) && isset($_POST['pass'])){
	$u=$_POST['nom'];
	$p=$_POST['pass'];
	if($u!="" || $p!=""){
		$resultado=$mysqli->query("select * from usuarios where
			nombre='$u'
			and password='".sha1($p)."'")or die($mysqli->error);
		if(mysqli_num_rows($resultado)==0){
			header("Location: ../login.php?error=No existe este usuario");
		}else{
			$fila=$resultado->fetch_assoc();//traer una fila
			$id=$fila['idUsuario'];
			$nom=$fila['nombre'];
			$nivel=$fila['nivel'];
			$_SESSION['Id']=$id;
			$_SESSION['secret']=array(
				'Id' => $id,
				'Nombre' => $nom,
				'Permiso' => $nivel
			);
			header("Location: ../ordenes.php?id=0&clave=0&mesa=0");
		}
	}else{
		header("Location: ../login.php?error=Campos no se han completados");
	}
}else{
	header("Location: ../login.php?error=campos no completados");
}
?>
