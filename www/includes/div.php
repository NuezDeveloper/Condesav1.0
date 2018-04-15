<div id="instrucciones" style="opacity: .9;">
</div>
<?php
  if(isset($_GET['error'])){
    printf("<script type='text/javascript'>alert('".$_GET['error']."'); </script>");
  }
  if(isset($_GET['mensaje'])){
    printf("<script type='text/javascript'>alert('".$_GET['mensaje']."'); </script>");
  }
?>
