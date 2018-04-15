<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$base_de_datos = 'restaurant';

$mysqli = new mysqli($host, $user, $pass, $base_de_datos);
	if($mysqli->connect_error){
		die("No se pudo conectar al servidor".mysqli_connect_error());
	}
?>
