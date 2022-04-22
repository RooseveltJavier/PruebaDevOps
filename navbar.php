	<?php
  /* Connect To Database*/
  require_once ("config/db.php");
  require_once ("config/conexion.php");
  /* Call funciones*/
  include("funciones.php");
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php
        $empresa = get_empresa();
      ?>
      <a class="navbar-brand" href="#"><?php print_r($empresa[0]); ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $active_facturas;?>"><a href="facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Facturas <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_n_venta;?>"><a href="nventa.php"><i class='glyphicon glyphicon-list-alt'></i> Nota Venta</a></li>
     <li class="<?php echo $active_proformas;?>"><a href="proformas.php"><i class='glyphicon glyphicon-inbox'></i> Proformas</a></li>
    <li class="<?php echo $active_productos;?>"><a href="productos.php"><i class='glyphicon glyphicon-barcode'></i> Productos</a></li>
    <li class="<?php echo $active_superproductos;?>"><a href="superproductos.php"><i class='glyphicon glyphicon-qrcode'></i> S.Productos</a></li>
		<li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
    <!--<li class="<?php echo $active_reportes;?>"><a href="reporte.php"><i class='glyphicon glyphicon-book'></i> Reportes</a></li>
    <li class="<?php echo $active_cotizar;?>"><a href="nueva_cotizacion.php"><i class='glyphicon glyphicon-usd'></i> Cotizar</a></li>-->
		<li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
		<li class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><a href="perfil.php"><i  class='glyphicon glyphicon-cog'></i> Config.</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="https://wa.me/593982355129" target='_blank'><i class='glyphicon glyphicon-phone'></i> </a></li>
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>