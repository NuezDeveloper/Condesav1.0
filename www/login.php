<html>
<head lang="es">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/login.css">
  <title>LogIn</title>
</head>
<body>
  <div id="login">
  </div>
  <?php
    include "./includes/div.php";
  ?>
  <div class="panel">
    <div class="formulario">
      <div class="logo">
      </div>
      <form action="./php/login.php" method="POST">
        <div class="group">
          <fieldset>
            <input type="text" name="nom" value="">
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Usuario</label>
          </fieldset>
        </div>
        <div class="group">
          <fieldset>
            <input type="password" name="pass" value="" >
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Contraseña</label>
          </fieldset>
        </div>
        <input type="submit" value="INGRESAR">
      </form>
    </div>
    <div class="imagen">
      <button type="button" name="button" onclick="cerrar()">X</button>
    </div>
    <label style="color:white;margin-top:41.5%;margin-left:65%;">Creado por: Alonso Núñez</label>
  </div>
</body>
<script type="text/javascript">
  function cerrar(){
    window.close();
  }
</script>
</html>
