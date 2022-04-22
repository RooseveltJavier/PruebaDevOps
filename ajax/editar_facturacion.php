<?php
	
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura= $_SESSION['id_factura'];
$numero_factura= $_SESSION['numero_factura'];
if (isset($_POST['id'])){$id=intval($_POST['id']);}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{

$sql=mysqli_query($con, "select * from products where id_producto='".$id."'");
	while ($row=mysqli_fetch_array($sql))
	{
		$id_producto=$id;
		//$cantidad=$row['cantidad'];
		$combo_producto=$row['combo_producto'];
		$cant_combo_producto=$row['cant_combo_producto'];

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

$insert_tmp=mysqli_query($con, "INSERT INTO detalle_factura (numero_factura, id_producto,cantidad,precio_venta) VALUES ('$numero_factura','$id','$cantidad','$precio_venta')");

}


if (isset($_GET['id']))//codigo elimina un elemento del array
{

$id_detalle=intval($_GET['id']);
$sql=mysqli_query($con, "select * from products, detalle_factura where products.id_producto=detalle_factura.id_producto and detalle_factura.id_detalle='".$id_detalle."'");
	while ($row=mysqli_fetch_array($sql))
	{
		$id_producto=$row["id_producto"];
		$cantidad=$row['cantidad'];
		$combo_producto=$row['combo_producto'];
		$cant_combo_producto=$row['cant_combo_producto'];

		/*Update cantidad - INVENTARIO*/
		if(empty($combo_producto)){
			$update_producto=mysqli_query($con, "UPDATE products SET cantidad_producto= cantidad_producto+'".$cantidad."' WHERE id_producto='".$id_producto."'");
		}else{
			/*SUPERPRODUCTO*/
			$arrayC = explode(",", $cant_combo_producto);
			$array = explode(",", $combo_producto);
			for($i=0; $i < count($array); $i++) {
			    $update_producto=mysqli_query($con, "UPDATE products SET cantidad_producto= cantidad_producto+('".$cantidad * $arrayC[$i]."') WHERE codigo_producto='".$array[$i]."'");
			}
		}
	}

	/*Eliminar de detalle_factura*/
	$id_detalle=intval($_GET['id']);	
	$delete=mysqli_query($con, "DELETE FROM detalle_factura WHERE id_detalle='".$id_detalle."'");
}


$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<table class="table">
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;$sumador_sinIVA=0;
	$sql=mysqli_query($con, "select * from products, facturas, detalle_factura where facturas.numero_factura=detalle_factura.numero_factura and  facturas.id_factura='$id_factura' and products.id_producto=detalle_factura.id_producto");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_detalle=$row["id_detalle"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	$iva_producto=$row['status_producto'];
	
	$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	//$sumador_total+=$precio_total_r;//Sumador
	if($iva_producto!=0){
		$sumador_total+=$precio_total_r;//Sumador
	}else{
		$sumador_sinIVA+=$precio_total_r;//Sumador
	}

	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td><?php echo $nombre_producto;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal_general=number_format($sumador_total+$sumador_sinIVA,2,'.','');
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva+$sumador_sinIVA;


	/*$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;*/
	$update=mysqli_query($con,"update facturas set total_venta='$total_factura' where id_factura='$id_factura'");
?>
<tr>
	<td class='text-right' colspan=4>SUBTOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4>SUBTOTAL 0% <?php echo $simbolo_moneda;?> </td>
	<td class='text-right'> <?php echo number_format($sumador_sinIVA,2);?></td>
</tr>
<tr>
	<td class='text-right' colspan=4>SUBTOTAL 12% <?php echo $simbolo_moneda;?> </td>
	<td class='text-right'> <?php echo number_format($subtotal,2);?></td>
</tr>
<tr>
	<td class='text-right' colspan=4>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4>TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<td></td>
</tr>

</table>
