
<?php
  $llevar = $mysqli->query("select * from referencia where mesa='llevar'");
  while($filallevar = mysqli_fetch_array($llevar)){
      echo "<a href='./ordenes.php?id=".$_GET['id']."&clave=".$_GET['clave']."&mesa=".$filallevar['idRef']."'>".$filallevar['referencia']."</a>";
  }
  $mesas = $mysqli->query("select * from referencia where mesa!='llevar'");
  while($filaMesas = mysqli_fetch_array($mesas)){
      echo "<a href='./ordenes.php?id=".$_GET['id']."&clave=".$_GET['clave']."&mesa=".$filaMesas['idRef']."'>Mesa ".$filaMesas['mesa']."</a>";
  }
?>
