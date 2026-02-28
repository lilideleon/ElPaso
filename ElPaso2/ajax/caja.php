<?php 
	require_once "../modelos/Caja.php";
		
	$Ejecuta=new Caja();
	$FechaInicio = $_POST['FechaInicio'];
	$FechaFin = $_POST['FechaFin'];


	$rspta=$Ejecuta->TotalDia($FechaInicio,$FechaFin);
	echo json_encode($rspta);

 ?>