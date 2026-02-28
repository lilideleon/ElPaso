<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Caja
{


	//implementamos nuestro constructor

	public function __construct(){

	}



	//implementar un metodopara mostrar los datos de unregistro a modificar

	public function TotalDia($FechaInicio,$FechaFin)
	{
		$sql="SELECT SUM(Total_venta) as Totalventas FROM venta WHERE venta.fecha_hora  BETWEEN '".$FechaInicio."' AND '".$FechaFin."' and venta.estado = 'Aceptado'";
		return ejecutarConsultaSimpleFila($sql);
	}



}

 ?>
