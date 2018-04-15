<?php
  include 'conexion.php';
  $today=$mysqli->query("select CURDATE() as fechonga from ventas")or die($mysqli->error);
  if($present=mysqli_fetch_array($today)){
    $hoy=$present['fechonga'];
    header("Location: ../cortes.php?fecha=$hoy");
  }
?>
