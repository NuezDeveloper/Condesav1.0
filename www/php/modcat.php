<?php
include 'conexion.php';
$cat=$_POST['cat'];
$nom=$_POST['nom'];
if(isset($cat)&&isset($nom)){
	if($nom==""){
		header("Location: ../inventario.php?id=0&clave=0&mesa=0&error=No se han llenado los campos");
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
				$mysqli->query("update categorias set categoria = '".$nom."', imagen = '".$nombrefinal."' where categoria = '".$cat."'")or die("ERROR: " .$mysqli->error);
        header("location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Categoría modificada");
			}else{
				echo "Error 500";
			}
		}else{
			$mysqli->query("update categorias set categoria = '".$nom."' where categoria = '".$cat."'")or die("ERROR: " .$mysqli->error);
			header("location: ../inventario.php?id=0&clave=0&mesa=0&mensaje=Categoría modificada");
		}

		}
	}else{
		//header("Location: ../registro.php?error=Campos Vacios" );
	}
 ?>
