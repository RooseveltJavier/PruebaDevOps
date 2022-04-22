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
		$sWhere = "JOIN detalle_factura ON facturas.numero_factura = detalle_factura.numero_factura ";
		if ( $_GET['ini'] != "" && $_GET['fin'] ){
			$sWhere.= " RIGHT JOIN products ON products.id_producto = detalle_factura.id_producto AND(fecha_factura BETWEEN '".$_REQUEST['ini']." 00:00:00' AND '".$_REQUEST['fin']." 23:59:59')";
			//$sWhere.= "(fecha_factura BETWEEN '".$_REQUEST['ini']." 00:00:00' AND '".$_REQUEST['fin']." 23:59:59')";
		}
		/*SOLO FACTIRAS ESTADO=1 (PAGADAS) */
		$sWhere.="AND estado_factura = '1'";
		$sWhere.=" GROUP BY codigo_producto";
		$sWhere.=" order by products.id_producto";//desc

		$sql   = "SELECT codigo_producto, nombre_producto, SUM(detalle_factura.cantidad) AS cantidad, precio_iva_producto AS precio_iva, SUM(detalle_factura.cantidad * precio_iva_producto) AS precio FROM $sTable  $sWhere";


		$query = mysqli_query($con, $sql);
		//loop through fetched data
		$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);

		if (!empty($query)){
			echo mysqli_error($con);
			?>

			<div class="table-responsive">
			  <table class="table" id="tblData">
				<tr  class="info">
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Cantidad</th>
					<th>Precio unitario</th>
					<th>Precio total</th>
					<th >Facturas</th><!-- class='text-right' -->
					
				</tr>
				<?php

				while ($row=mysqli_fetch_array($query)){
						$codigo_producto=$row['codigo_producto'];
						$nombre_producto=$row['nombre_producto'];
						$cantidad=$row['cantidad'];
						$precio_iva=$row['precio_iva'];
						$precio=$row['precio'];


					$sTable1 = "facturas, detalle_factura, products";//clientes, users
					$sWhere1 = "";
					 $sWhere1.=" WHERE facturas.numero_factura = detalle_factura.numero_factura AND detalle_factura.id_producto = products.id_producto";
					if ( $_GET['ini'] != "" && $_GET['fin'] ){
						$sWhere1.= " AND(fecha_factura BETWEEN '".$_REQUEST['ini']." 00:00:00' AND '".$_REQUEST['fin']." 23:59:59')";
						$sWhere1.= " AND  (products.codigo_producto=".$codigo_producto." )";
					}

					$sWhere1.=" AND facturas.estado_factura = '1'";
					$sql1="SELECT facturas.numero_factura FROM  $sTable1 $sWhere1 ";
					$query1 = mysqli_query($con, $sql1);
					
					$cont=0;
					$facturas_concat="";
					while ($row1=mysqli_fetch_array($query1)){
						$numero_factura=$row1['numero_factura'];
						if($cont==0){
							$facturas_concat=$numero_factura;
						}else{
							$facturas_concat=$facturas_concat.",".$numero_factura;
						}
						$cont++;
					}

					?>
					<tr>
						<td align="center"><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto; ?></td>
						<td><?php echo $cantidad; ?></td>
						<td><?php echo $precio_iva; ?></td>
						<td><?php echo number_format ($precio,2); ?></td>
						<td><?php echo $facturas_concat; ?></td>							
					</tr>
					<?php
				}
				?>

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
	fileName: "Productos por factura",    //Nombre del archivo 
});
</script>