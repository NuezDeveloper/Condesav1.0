<?php
  $fecha=$_POST['date'];
  if(isset($_POST['date'])){
    if($fecha == ""){
      $fecha=date("Y_m_d");
      header("Location: ../ventas.php?id=0&fecha=$fecha");
    }else{
      header("Location: ../ventas.php?id=0&fecha=".$fecha);
    }
  }else{

  }
?>
