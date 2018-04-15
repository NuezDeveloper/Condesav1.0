<?php
  $fecha=$_POST['date'];
  if(isset($_POST['date'])){
    if($fecha == ""){
      $fecha=date("Y_m_d");
      header("Location: ../cortes.php?fecha=$fecha");
    }else{
      header("Location: ../cortes.php?fecha=".$fecha);
    }
  }else{
    header("Location: ../cortes.php?fecha=0&error=No hay ventas para un corte");
  }
?>
