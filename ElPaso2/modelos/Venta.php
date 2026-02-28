<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Venta{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento,$PrecioCosto){
	global $conexion;

	// Validaciones mínimas para evitar inserts parciales por arrays desalineados
	if (!is_array($idarticulo) || count($idarticulo) === 0) {
		return "No se recibieron artículos para el detalle de la venta.";
	}
	if (!is_array($cantidad) || !is_array($precio_venta) || !is_array($descuento) || !is_array($PrecioCosto)) {
		return "Detalle inválido: faltan arrays de cantidad/precio/descuento/costo.";
	}

	// Transacción: si falla un detalle, se revierte también la cabecera
	ejecutarConsulta("START TRANSACTION");

	$sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado) VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
	$idventanew=ejecutarConsulta_retornarID($sql);
	if (empty($idventanew)) {
		$err = isset($conexion) ? $conexion->error : '';
		ejecutarConsulta("ROLLBACK");
		return "No se pudo registrar la venta (cabecera). ".$err;
	}

	$sw=true;
	$errores=array();
	for ($i = 0; $i < count($idarticulo); $i++) {
		// Evita notices y permite identificar fallos por índice
		$det_idarticulo = isset($idarticulo[$i]) ? $idarticulo[$i] : null;
		$det_cantidad = isset($cantidad[$i]) ? $cantidad[$i] : null;
		$det_precio_venta = isset($precio_venta[$i]) ? $precio_venta[$i] : null;
		$det_descuento = isset($descuento[$i]) ? $descuento[$i] : 0;
		$det_precio_costo = isset($PrecioCosto[$i]) ? $PrecioCosto[$i] : null;

		if ($det_idarticulo === null || $det_idarticulo === '') {
			$sw=false;
			$errores[]="Detalle[$i]: idarticulo vacío.";
			continue;
		}
		if ($det_cantidad === null || $det_cantidad === '' || floatval($det_cantidad) <= 0) {
			$sw=false;
			$errores[]="Detalle[$i] art=$det_idarticulo: cantidad inválida ($det_cantidad).";
			continue;
		}

		// Bloquea el artículo para evitar carreras y validar stock
		$stockRs = ejecutarConsulta("SELECT stock FROM articulo WHERE idarticulo='$det_idarticulo' FOR UPDATE");
		$stockFila = ($stockRs && method_exists($stockRs, 'fetch_assoc')) ? $stockRs->fetch_assoc() : null;
		if (!$stockFila || !isset($stockFila['stock'])) {
			$sw=false;
			$errores[]="Detalle[$i] art=$det_idarticulo: artículo no encontrado para validar stock.";
			continue;
		}
		$stockAntes = floatval($stockFila['stock']);
		$cantidadNumerica = floatval($det_cantidad);
		if ($stockAntes < $cantidadNumerica) {
			$sw=false;
			$errores[]="Detalle[$i] art=$det_idarticulo: stock insuficiente (stock=$stockAntes, requerido=$cantidadNumerica).";
			continue;
		}

		$sql_detalle="INSERT INTO detalle_venta (idventa,idarticulo,cantidad,precio_venta,descuento,PrecioCosto) VALUES('$idventanew','$det_idarticulo','$det_cantidad','$det_precio_venta','$det_descuento','$det_precio_costo')";
		if (!ejecutarConsulta($sql_detalle)) {
			$sw=false;
			$err = isset($conexion) ? $conexion->error : '';
			$errores[]="Detalle[$i] art=$det_idarticulo: $err";
			continue;
		}

		// Descontar stock si la BD no lo hizo vía trigger
		$stockRsDespues = ejecutarConsulta("SELECT stock FROM articulo WHERE idarticulo='$det_idarticulo'");
		$stockFilaDespues = ($stockRsDespues && method_exists($stockRsDespues, 'fetch_assoc')) ? $stockRsDespues->fetch_assoc() : null;
		$stockDespues = ($stockFilaDespues && isset($stockFilaDespues['stock'])) ? floatval($stockFilaDespues['stock']) : null;
		if ($stockDespues === null) {
			$sw=false;
			$errores[]="Detalle[$i] art=$det_idarticulo: no se pudo leer stock luego del detalle.";
			continue;
		}

		// Si no cambió, asumimos que no hay trigger de inventario y actualizamos nosotros
		if (abs($stockDespues - $stockAntes) < 0.000001) {
			$sql_stock = "UPDATE articulo SET stock = stock - $cantidadNumerica WHERE idarticulo='$det_idarticulo'";
			if (!ejecutarConsulta($sql_stock)) {
				$sw=false;
				$err = isset($conexion) ? $conexion->error : '';
				$errores[]="Detalle[$i] art=$det_idarticulo: no se pudo descontar stock. $err";
				continue;
			}
		}
	}

	if ($sw) {
		ejecutarConsulta("COMMIT");
		return true;
	}

	ejecutarConsulta("ROLLBACK");
	return "Venta no guardada: falló al menos un detalle. ".implode(" | ", $errores);
}

public function anular($idventa){
	$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
	return ejecutarConsulta($sql);
}


//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idventa){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE idventa='$idventa'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idventa){
	$sql="SELECT dv.idventa,dv.idarticulo,IFNULL(a.nombre,'[Artículo no disponible]') as nombre,dv.cantidad,dv.precio_venta,dv.PrecioCosto,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv LEFT JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE dv.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.idventa as Factura, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER BY v.idventa DESC";
	return ejecutarConsulta($sql);
}


public function ventacabecera($idventa){
	$sql= "SELECT v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.impuesto, v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalles($idventa){
	$sql="SELECT a.nombre AS articulo, a.codigo, d.cantidad, d.precio_venta,d.PrecioCosto, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
         return ejecutarConsulta($sql);
}


public function Ganancia($FechaInicio,$FechaFin){
	$sql="SELECT venta.idventa, venta.fecha_hora,detalle_venta.cantidad,articulo.nombre,articulo.PrecioCosto,detalle_venta.precio_venta, detalle_venta.descuento,
ROUND(((detalle_venta.precio_venta - detalle_venta.PrecioCosto) * detalle_venta.cantidad) - detalle_venta.descuento,2) as ganancia FROM venta,articulo,detalle_venta WHERE detalle_venta.idarticulo = articulo.idarticulo and detalle_venta.idventa = venta.idventa AND venta.fecha_hora BETWEEN '".$FechaInicio."' and '".$FechaFin."' and venta.estado = 'Aceptado' and articulo.idarticulo != '318'";
         return ejecutarConsulta($sql);
}

}

 ?>
