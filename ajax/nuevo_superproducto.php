<?php
/*
Estado corresponde a IVA o sin IVA
*/

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['codigo'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado del producto";
		} else if (empty($_POST['precio'])){
			$errors[] = "Precio de venta vacío";
		} else if (empty($_POST['precio_iva'])){
			$errors[] = "Precio con IVA vacío";
		}else if (
			!empty($_POST['codigo']) &&
			!empty($_POST['nombre']) &&
			$_POST['estado']!="" &&
			!empty($_POST['precio'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$cantidad=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad"],ENT_QUOTES)));
		$estado=intval($_POST['estado']);
		$precio_venta=floatval($_POST['precio']);
		$precio_iva=floatval($_POST['precio_iva']);
		$date_added=date("Y-m-d H:i:s");

		$subproducto = $_POST['subproductos'];	
		$subproductos= "";$cont=0;
		foreach ($subproducto as $value){
			if(count($subproducto)==1){
				$subproductos= $value;
			}else{

				if($cont==0){
					$subproductos.= $value;
				}else{
					$subproductos.= ",".$value;
				}
			}   $cont++;
		}	
		$cant_combo = $_POST['subcantidades'];
		$subcantidad_combo="";$cont=0;
		foreach ($cant_combo as $value){
			if(count($cant_combo)==1){
				$subcantidad_combo= $value;
			}else{

				if($cont==0){
					$subcantidad_combo.= $value;
				}else{
					$subcantidad_combo.= ",".$value;
				}
			}   $cont++;
		}

		$sql="INSERT INTO products (codigo_producto, nombre_producto, cantidad_producto, status_producto, date_added, precio_producto,precio_iva_producto,combo_producto,cant_combo_producto) VALUES ('$codigo','$nombre','$cantidad','$estado','$date_added','$precio_venta','$precio_iva','$subproductos','$subcantidad_combo')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Producto ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>