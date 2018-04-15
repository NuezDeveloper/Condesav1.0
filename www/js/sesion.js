function show(){
  document.getElementById('sesion').style.display="block";
}
function unshow(){
  document.getElementById('sesion').style.display="none";
}
function mouseOver(mensaje) {
  var di = document.getElementById('instrucciones');
  di.style.display="block";
  di.innerHTML ="<p>"+mensaje+"</p>";
}

function mouseOut() {
  document.getElementById('instrucciones').style.display="none";
}
