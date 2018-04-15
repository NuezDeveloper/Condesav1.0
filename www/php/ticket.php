<?php


require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$nombre_impresora = "POS58";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer->text("Hola inge saul");
for($i=0;$i<=5;$i++){
  $printer->feed();
}
$printer->feedReverse();
$printer->cut();

$printer->pulse();

$printer->close();
?>
