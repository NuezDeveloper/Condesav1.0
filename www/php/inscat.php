<?php
include 'conexion.php';
$cat=$_POST['nom'];
if(isset($cat)){
	if($cat==""){
		header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=Favor de llenar todos los campos");
	}else{
		$MIME=$_FILES['imagen']['type'];
		if( ($MIME=='image/jpg') ||
			($MIME=='image/jpeg') ||
			($MIME=='image/pjpeg') ||
			($MIME=='image/x-png') ||
			($MIME=='image/gif') ||
			($MIME=='image/png') ){
			$random=rand(2,9999999);
			$random2=rand(2,9999999);
			$fecha=date("Y_m_d");
			$nombrefinal=$random.'_'.$random2.'_'.$fecha.'_'.$_FILES['imagen']['name'];
			if(move_uploaded_file($_FILES['imagen']['tmp_name'],"../img/".$nombrefinal)){
				$mysqli->query("insert into categorias values(0,'$cat','$nombrefinal')")or die("ERROR: " .$mysqli->error);
				header("location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Categoría agregada");
			}else{
				echo "Error 500";
			}
		}else{
			$mysqli->query("insert into categorias values(0,'$cat','condesa.ico')")or die("ERROR: " .$mysqli->error);
			header("location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Categoría agregada");
		}

		}
	}
 ?>
