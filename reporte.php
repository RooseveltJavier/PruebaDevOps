<?php
	/*-------------------------
	Autor: INNOVAWEBSV
	Web: www.innovawebsv.com
	Mail: info@innovawebsv.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	$active_reportes="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Reporte ";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("head.php");?>

  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
			<div class="btn-group pull-right">
				<a  href="reporte.php" class="btn btn-info"><span class="glyphicon glyphicon-list" ></span> Facturas</a> 
				<a  href="reporte_por_producto.php" class="btn btn-info"><span class="glyphicon glyphicon-th-list" ></span> Productos vendidos</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> REPORTE - Buscar Facturas</h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">DESDE</label>
							<div class="col-md-3">
								<input type="date" id="inicio" name="trip-inicio" value="<?php echo date('Y-m-d'); ?>" min="2020-01-01" max="2030-12-31">
							</div>
							<label for="q" class="col-md-2 control-label">HASTA</label>
							<div class="col-md-3">
								<input type="date" id="fin" name="trip-fin" value="<?php echo date('Y-m-d'); ?>" min="2020-01-01" max="2030-12-31">
							</div>
							
							
							
							<div class="col-md-2">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
		
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/reportes.js"></script>
  </body>
</html>