<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_proforma=intval($_GET['id']);
		$del1="delete from proformas where numero_proforma='".$numero_proforma."'";
		$del2="delete from detalle_proforma where numero_proforma='".$numero_proforma."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "proformas, clientes, users";
		 $sWhere = "";
		 $sWhere.=" WHERE proformas.id_cliente=clientes.id_cliente and proformas.id_vendedor=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or proformas.numero_proforma like '%$q%')";
			
		}
		
		$sWhere.=" order by proformas.id_proforma desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './proformas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Estado</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_proforma=$row['id_proforma'];
						$numero_proforma=$row['numero_proforma'];
						$fecha=date("d/m/Y", strtotime($row['fecha_proforma']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$estado_factura=$row['estado_proforma'];
						if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Anulada";$label_class='label-danger';}
						$total_venta=$row['total_venta'];
					?>
					<tr>
						<td><?php echo $numero_proforma; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>					
					<td class="text-right">
						<a href="editar_proforma.php?id_proforma=<?php echo $id_proforma;?>" class='btn btn-default' title='Editar proforma' ><i class="glyphicon glyphicon-edit"></i></a>
						<a href="#" class='btn btn-default' title='Descargar proforma' onclick="imprimir_proforma('<?php echo $id_proforma;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<a href="#" class='btn btn-default' title='Borrar proforma' onclick="eliminar('<?php echo $numero_proforma; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
						
						<?php
						if ($estado_factura==1){
						?>
						<spam> | </spam>
						<a href="#" onclick="prof_to_fact('<?php echo $numero_proforma; ?>')" class='btn btn-warning' title='Generar Factura' ><i class="glyphicon glyphicon-edit"></i></a>
						<?php } ?>

					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>
