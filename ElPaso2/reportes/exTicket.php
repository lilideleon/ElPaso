<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
  Este ejemplo imprime un
  ticket de venta desde una impresora térmica
*/


/*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
  escribe el nombre de la tuya. Recuerda que debes compartirla
  desde el panel de control
*/

$nombre_impresora = "POS-801"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
#Mando un numero de respuesta para saber que se conecto correctamente.
echo 1;
/*
  Vamos a imprimir un logotipo
  opcional. Recuerda que esto
  no funcionará en todas las
  impresoras

  Pequeña nota: Es recomendable que la imagen no sea
  transparente (aunque sea png hay que quitar el canal alfa)
  y que tenga una resolución baja. En mi caso
  la imagen que uso es de 250 x 250
*/

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

/*
  Intentaremos cargar e imprimir
  el logo
*/
try{
  $logo = EscposImage::load("ico.jpg", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}

/*
  Ahora vamos a imprimir un encabezado
*/

require_once "../modelos/Venta.php";

$venta = new Venta();
$rspta = $venta->ventacabecera($_GET["id"]);
$reg=$rspta->fetch_object();

$printer->text("\n"."FERRETERIA EL PASO" . "\n");
$printer->text("CASERIO PASO ROJO, ALDEA RECUERDO A BARRIOS" . "\n");
$printer->text("SAN CARLOS SIJA" . "\n");
$printer->text("Tel: 32006681" . "\n");
#La fecha también
date_default_timezone_set("America/Guatemala");
$printer->text("FECHA IMPRESION:".date("Y-m-d H:i:s") . "\n");
$printer->text("FECHA CREACION:" . $reg->fecha. "\n");
$printer->text("CLIENTE:" . $reg->cliente. "\n");
$printer->text("NO COMPROBANTE:" . $reg->idventa. "\n");
$printer->text("----------------------------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANT  DESCRIPCION   SubTotal.\n");
$printer->text("----------------------------------------------"."\n\n");
/*
  Ahora vamos a imprimir los
  productos
*/


    $rsptad = $venta->ventadetalles($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
      $printer->text("");
      $printer->text($regd->cantidad."     ".$regd->articulo."  Q.".$regd->subtotal."\n");
      $cantidad+=$regd->cantidad;
     } 


  /*Alinear a la izquierda para la cantidad y el nombre*/
 /* $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Producto Galletas\n");
    $printer->text( "2  pieza    10.00 20.00   \n");
    $printer->text("Sabrtitas \n");
    $printer->text( "3  pieza    10.00 30.00   \n");
    $printer->text("Doritos \n");
    $printer->text( "5  pieza    10.00 50.00   \n");*/
/*
  Terminamos de imprimir
  los productos, ahora va el total
*/
$printer->text("----------------------------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("TOTAL: Q.".$reg->total_venta."\n\n");


/*
  Podemos poner también un pie de página
*/
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("ESTE DOCUMENTO ES UN COMPROBANTE DE VENTA\n");
$printer->text("POR FAVOR PIDA SU FACTURA\n");



/*Alimentamos el papel 3 veces*/
$printer->feed(3);

/*
  Cortamos el papel. Si nuestra impresora
  no tiene soporte para ello, no generará
  ningún error
*/
$printer->cut();

/*
  Por medio de la impresora mandamos un pulso.
  Esto es útil cuando la tenemos conectada
  por ejemplo a un cajón
*/
$printer->pulse();

/*
  Para imprimir realmente, tenemos que "cerrar"
  la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();


?>