<link href="dist/css/tableexport.css" rel="stylesheet" type="text/css">
<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include("../funciones.php");
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	/*REPORTE FACTURAS*/
	if($action == 'ajax'){
		$_REQUEST['ini'];
		$_REQUEST['fin'];

		$sTable = "facturas";
		$sWhere = "WHERE ";
		if ( $_GET['ini'] != "" && $_GET['fin'] ){
			$sWhere.= "(fecha_factura BETWEEN '".$_REQUEST['ini']." 00:00:00' AND '".$_REQUEST['fin']." 23:59:59')";
		}
		/*SOLO FACTIRAS ESTADO=1 (PAGADAS) */
		$sWhere.="AND estado_factura='1'";
		$sWhere.=" order by id_factura desc";

		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];

		//$reload = './reporte.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere ";

		$query = mysqli_query($con, $sql);
		//loop through fetched data

		$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);

		if ($numrows>0){
			echo mysqli_error($con);
			?>

			<div class="table-responsive">
			  <table class="table" id="tblData">
				<tr  class="info">
					<th># Factura</th>
					<th>Fecha</th>
					<th>Subtotal 0%</th>
					<th>Subtotal <?php echo $impuesto; ?>%</th>
					<th>IVA <?php echo $impuesto; ?>%</th>
					<th >Total</th><!-- class='text-right' -->
					
				</tr>
				<?php
				$sumT_cero=0;$sumT_impuesto=0;$sumT_iva=0;$sumT_total=0;
				while ($row=mysqli_fetch_array($query)){
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$total_venta=$row['total_venta'];

				/*INICIO */
					$sTable1 = "facturas, detalle_factura, products";//clientes, users
					$sWhere1 = "";
					 $sWhere1.=" WHERE facturas.numero_factura=detalle_factura.numero_factura AND detalle_factura.id_producto = products.id_producto";
					if ( $_GET['ini'] != "" && $_GET['fin'] ){
						$sWhere1.= " and  (facturas.numero_factura = ".$numero_factura." )";
					}
					/*SOLO FACTIRAS ESTADO=1 (PAGADAS) */
					$sWhere1.="AND facturas.estado_factura='1'";
					$sWhere1.=" order by facturas.id_factura desc";

					$sql1="SELECT * FROM  $sTable1 $sWhere1 ";

					$query1 = mysqli_query($con, $sql1);
					
					$sumador_total=0;$sumador_sinIVA=0;
					while ($row1=mysqli_fetch_array($query1)){
						$cantidad=$row1['cantidad'];
						$iva_producto=$row1['status_producto'];
						$precio_venta=$row1['precio_venta'];
						$precio_venta_f=number_format($precio_venta,2);//Formateo variables
						$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
						$precio_total=$precio_venta_r*$cantidad;
						$precio_total_f=number_format($precio_total,2);//Precio total formateado
						$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas

						if($iva_producto!=0){
							$sumador_total+=$precio_total_r;//Sumador
						}else{
							$sumador_sinIVA+=$precio_total_r;//Sumador
						}
						
						$subtotal_general=number_format($sumador_total+$sumador_sinIVA,2,'.','');
						$subtotal=number_format($sumador_total,2,'.','');
						$total_iva=($subtotal * $impuesto )/100;
						$total_iva=number_format($total_iva,2,'.','');
						//$total_factura=$subtotal+$total_iva+$sumador_sinIVA;
					}
				/*FIN */

					$sumT_cero+=$sumador_sinIVA;
					$sumT_impuesto+=$subtotal;
					$sumT_iva+=$total_iva;
					$sumT_total+=$total_venta;
					?>
					<tr>
						<td align="center"><?php echo $numero_factura; ?></td>
						<td><?php echo $fecha; ?></td>

						<td><?php echo $sumador_sinIVA; ?></td>
						<td><?php echo $subtotal; ?></td>
						<td><?php echo $total_iva; ?></td>

						<td><?php echo number_format ($total_venta,2); ?></td>						
					</tr>
					<?php
				}
				?>
				<tr><th colspan="6"></th></tr>
				<tr class="danger">
				<th colspan="2"></th>
				<th><?php echo $sumT_cero; ?></th>
				<th><?php echo $sumT_impuesto; ?></th>
				<th><?php echo $sumT_iva; ?></th>
				<th><?php echo $sumT_total; ?></th><!-- class='text-right' -->	
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>

<script src="dist/jquery-1.12.4.min.js"></script>
<script src="dist/FileSaver.min.js"></script>
<script src="dist/Blob.min.js"></script>
<script src="dist/xls.core.min.js"></script>
<script src="dist/js/tableexport.js"></script>
<script>
$("table").tableExport({
	formats: ["xlsx"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Reporte_diario",    //Nombre del archivo 
});
</script>