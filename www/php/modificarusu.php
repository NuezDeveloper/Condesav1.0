<?php
	include 'conexion.php';
	$id=$_POST['iduser'];
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$cpass=$_POST['cpass'];
	$passlast=$_POST['passlast'];
	$permiso=$_POST['permiso'];
	if(isset($_POST['user'])&&isset($_POST['pass'])&&isset($_POST['iduser'])&&isset($_POST['cpass'])&&isset($_POST['passlast'])){
		if($user=="" && $pass=="" && $id=="" && $cpass=="" && $passlast==""){
			header("Location: ../usuarios.php?id=0&error=No se han llenado todos los campos");
		}else{
			if($pass==$cpass){
				$encriptada=sha1($pass);
				$encriptada2=sha1($passlast);

        $correcta = $mysqli->query("select * from usuarios where idUsuario = $id")or die($mysqli->error);

        if($existe = mysqli_fetch_array($correcta)){
          if($existe['password']==$encriptada2){
            $mysqli->query("update usuarios set nombre = '$user', password='$encriptada', nivel = $permiso where idUsuario = $id")or die($mysqli->error());
    				header("Location: ../usuarios.php?id=0&mensaje=Usuario modificado");
          }else{
            header("Location: ../usuarios.php?id=0&error=Las contraseñas no coinciden");
          }
        }else{

        }
			}else{
				header("Location: ../usuarios.php?id=0&error=Las contraseñas no coinciden");
			}
		}
	}
?>
