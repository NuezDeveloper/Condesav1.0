<?php
	include 'conexion.php';
	$id=$_POST['id'];
	$nom=$_POST['nom'];
	$ap=$_POST['ap'];
	$am=$_POST['am'];
	$dom=$_POST['dom'];
	$tel=$_POST['tel'];
	$puesto=$_POST['puesto'];
	if(isset($_POST['nom'])&&isset($_POST['ap'])&&isset($_POST['am'])&&isset($_POST['dom'])&&isset($_POST['tel'])&&isset($_POST['puesto'])&&isset($_POST['id'])){
		if($nom=="" && $ap=="" && $am=="" && $dom=="" && $tel=="" && $puesto=="" && $id==""){
			header("Location: ../usuarios.php?error=Campos Vacios&id=0");
		}else{
      $MIME=$_FILES['foto']['type'];
      if( ($MIME=='image/jpg') ||
        ($MIME=='image/jpeg') ||
        ($MIME=='image/pjpeg') ||
        ($MIME=='image/x-png') ||
        ($MIME=='image/gif') ||
        ($MIME=='image/png') ){
        $random=rand(2,9999999);
        $random2=rand(2,9999999);
        $fecha=date("Y_m_d");
        $nombrefinal=$random.'_'.$random2.'_'.$fecha.'_'.$_FILES['foto']['name'];
        if(move_uploaded_file($_FILES['foto']['tmp_name'],"../img/".$nombrefinal)){
          $mysqli->query("update empleados set nombre = '$nom', apellidoPaterno = '$ap', apellidoMaterno = '$am', domicilio = '$dom', telefono = $tel, puesto = '$puesto', foto = '$nombrefinal' where idEmpleado = $id")or die($mysqli->error());
          header("Location: ../usuarios.php?id=$id&mensaje=Usuario modificado");
        }else{
          echo "Error 500";
        }
      }else{
				$mysqli->query("update empleados set nombre = '$nom', apellidoPaterno = '$ap', apellidoMaterno = '$am', domicilio = '$dom', telefono = $tel, puesto = '$puesto' where idEmpleado = $id")or die($mysqli->error());
				header("Location: ../usuarios.php?id=$id&mensaje=Usuario modificado");
      }
		}
	}
?>
