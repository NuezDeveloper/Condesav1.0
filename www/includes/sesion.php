<div id="sesion" onmouseover="show()" onmouseout="unshow()">
  <ul>
    <li><a href="./php/logout.php">Cerrar sesión</a></li>
    <li><a id="cerrarSistema">Cerrar sistema</a></li>
    <li><a href="./cortes.php?fecha=null">Hacer corte</a></li>
  </ul>
</div>

<style media="screen">
#alertaclose{
  width: 50%;
  min-height: 200px;
  box-shadow: 0px 0px 24px 1px rgba(186,186,186,1);
  background: white;
  left: 20%;
  top:150px;
  position: absolute;
  z-index: 12;
  display: none;
  overflow-y:scroll;
}
#alertaclose h4{
  text-align: center;
  font-size: 1.5rem;
  padding-top: 10px;
}
#alertaclose #cerrarclose{
  width: 30px;
  height: 30px;
  background: #ef2c2c;
  color: white;
  border: none;
  display: block;
  float: right;
  border-radius: 50%;
  margin-right: -10px;
  margin-top: -10px;
  cursor: pointer;
  margin-left: 0px;
}
</style>

<div id="alertaclose" style="top: 20px;">
  <button id="cerrarclose">
    <i class="fa fa-times"></i>
  </button>
  <h4>Seguro que desea cerrar el sistema?</h4>
  <button type="button" onclick="cerrar()" name="button" style="margin-top:10%;margin-left:37%;">Cerrar</button>
</div>

<script type="text/javascript">
  var sipi=false;
  window.addEventListener('load',function (argument) {
    document.getElementById("cerrarSistema").addEventListener('click',function(){
    var div=document.getElementById('alertaclose');
    if(sipi){
      div.className ="";
      sipi=false;
      div.style.display="none";
    }else{
      div.style.display="block";
      div.className +="iniciar";
      sipi=true;
    }
  });
  document.getElementById("cerrarclose").addEventListener('click',function(){
    var div=document.getElementById('alertaclose');
    div.className ="";
    si=false;
    div.style.display="none";
  });
  });
  function cerrar(){
    window.close();
  }
</script>
