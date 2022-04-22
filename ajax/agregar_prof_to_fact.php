<?php

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
if (isset($_GET['id'])){$id=$_GET['id'];}


	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$conf_p_to_f=true;

if (!empty($id))
{

$sql1=mysqli_query($con, "select * from detalle_proforma, products where detalle_proforma.id_producto = products.id_producto AND numero_proforma='".$id."'");

while ($row=mysqli_fetch_array($sql1)){
	$cantidad=$row["cantidad"];
	$cantidad_producto=$row["cantidad_producto"];
	$combo=$row["combo_producto"];
	$cant_combo=$row["cant_combo_producto"];

	if($combo){
		$array = explode(",", $combo);
		$arrayC = explode(",", $cant_combo);

		for($i=0; $i < count($array); $i++) {

			$totcantidad = $arrayC[$i]*$cantidad;
			$busqueda=mysqli_query($con, "SELECT cantidad_producto FROM products where codigo_producto='".$array[$i]."'");
			while ($row1=mysqli_fetch_array($busqueda))
			{
				$cantidad_producto=$row1["cantidad_producto"];
				if($cantidad_producto<$totcantidad){
					echo "<script>alert('Existen subproductos debajo del stock')</script>";
					$conf_p_to_f=false;
					break;
					exit;
				}
			}
		}
	}else{
		if($cantidad_producto<$cantidad){
			echo "<script>alert('Existen productos debajo del stock')</script>";
			$conf_p_to_f=false;
			break;
			exit;
		}
	}
}




	if($conf_p_to_f == true){
		$sql=mysqli_query($con, "select LAST_INSERT_ID(numero_factura) as last from facturas order by id_factura desc limit 0,1 ");
		$rw=mysqli_fetch_array($sql);
		$numero_factura=$rw['last']+1;	

		$sql=mysqli_query($con,"SELECT * FROM proformas where numero_proforma='".$id."'");
		while ($row=mysqli_fetch_array($sql))
			{
				/*$fecha_proforma=$row["fecha_proforma"];*/
				$id_cliente=$row["id_cliente"];
				$id_vendedor=$row["id_vendedor"];
				$condiciones=$row["condiciones"];
				$total_venta=$row["total_venta"];

			}

			$date=date("Y-m-d H:i:s");
			$insert=mysqli_query($con,"INSERT INTO facturas VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$condiciones','$total_venta','1')");

			$update_proforma=mysqli_query($con, "UPDATE proformas SET estado_proforma= 0 WHERE numero_proforma='".$id."'");


			$sql=mysqli_query($con, "select * from detalle_proforma, products where detalle_proforma.id_producto = products.id_producto AND numero_proforma='".$id."'");

			while ($row=mysqli_fetch_array($sql)){
				$id_producto=$row["id_producto"];
				$cantidad=$row["cantidad"];
				$precio_venta=$row['precio_venta'];
				$combo_producto=$row['combo_producto'];
				$cant_combo_producto=$row["cant_combo_producto"];

				//Insert en la tabla detalle_cotizacion
				$insert_detail=mysqli_query($con, "INSERT INTO detalle_factura VALUES ('','$numero_factura','$id_producto','$cantidad','$precio_venta')");

				/*Update cantidad - INVENTARIO*/
				if(empty($combo_producto)){
					$update_producto=mysqli_query($con, "UPDATE products SET cantidad_producto= cantidad_producto-'".$cantidad."' WHERE id_producto='".$id_producto."'");
				}else{
					/*SUPERPRODUCTO*/
					$arrayC = explode(",", $cant_combo_producto);
					$array = explode(",", $combo_producto);
					for($i=0; $i < count($array); $i++) {
					    $update_producto=mysqli_query($con, "UPDATE products SET cantidad_producto= cantidad_producto-('".$cantidad * $arrayC[$i]."') WHERE codigo_producto='".$array[$i]."'");
					}
				}

			}
	}



}

?>