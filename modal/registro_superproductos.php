	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" onmouseover="this.focus();" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required maxlength="255" ></textarea>
				  
				</div>
			  </div>


			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad de producto" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">IVA</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Precio</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio de venta del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>
			  <div class="form-group">
				<label for="precio_iva" class="col-sm-3 control-label">Precio IVA</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio_iva" name="precio_iva" placeholder="Precio con IVA del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>

			  <div class="form-group">
				  <label for="precio_iva" class="col-sm-3 control-label">Subproductos</label>
				  <div class="col-sm-8">
				  <span id="add_aut" class="btn btn-primary">+</span>
	                 <div id="auth-rows" class="row col-xs-12"></div>
				  </div>
			  </div>
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>  
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>

	<script type="text/javascript">


	        $("#add_aut").click(function(e){


				var html3 = '<input type="text" class="form-control" name="subproductos[]" placeholder="Código del producto" class="col-xs-6"><input type="text" class="form-control" name="subcantidades[]" placeholder="Cantidad del producto" class="col-xs-5"><button type="button" class="col-xs-1">-</button>';
	            $('#auth-rows').append(html3);
	   
				$("button").click(function() {
				   $(this).closest('div.form-group').remove();
				});

	        });



	</script>