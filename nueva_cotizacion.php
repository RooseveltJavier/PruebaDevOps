<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_facturas="";
	$active_cotizar="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Cotizar ";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	/*SE ELIMINA TODO EL CARRITO DE COMPRAS*/
	$delete=mysqli_query($con, "DELETE FROM tmp ");
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
			<h4><i class='glyphicon glyphicon-usd'></i> Cotizar</h4>
			
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			/*include("modal/registro_clientes.php");
			include("modal/registro_productos.php");*/
		?>
			<!--<form class="form-horizontal" role="form" id="datos_factura">-->

				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
						<span class="glyphicon glyphicon-search"></span> Agregar productos
						</button> | 
						<button class="btn btn-warning btn-lg" onClick="window.location.reload();">REINICIAR</button>
					</div>	
				</div>
			<!--</form>	-->
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/nueva_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	

  </body>
</html>