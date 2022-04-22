<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	/*background:#2c3e50;
	border: 1px solid black;*/
	border-bottom: 1px solid black;
	padding: 4px 4px 4px;
	color:black;
	font-weight:bold;
	font-size:10px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="0mm" style="font-size: 9pt; font-family: arial">
	<?php include("encabezado_proforma.php");?>
<hr>
	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
			<td style="width:50%;"><br>
				<span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?></span>
			<br><br>
				<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
					<tr>
						<td><img style="width: 20px" src="../../img/ruc.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','codigo_postal', 'id_perfil', 1);?></td>
					</tr>
					<tr>
						<td><img style="width: 20px" src="../../img/phone.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','telefono', 'id_perfil', 1);?></td>
					</tr>
					<tr>
						<td><img style="width: 20px" src="../../img/email.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','email', 'id_perfil', 1);?></td>
					</tr>
					<tr>
						<td><img style="width: 20px" src="../../img/direccion.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)?></td><!--." ".get_row('perfil','estado', 'id_perfil', 1);-->
					</tr>
				</table>
			</td>
			<td style="width:50%;"><br>
				<span style="color: #34495e;font-size:14px;font-weight:bold">DIRIGIDA A:</span>
				<br><br>
				<?php 
		        	$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
					$rw_cliente=mysqli_fetch_array($sql_cliente);
				?>
				<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
					<tr>
					   <td style="width:80%;"><?php echo $rw_cliente['nombre_cliente']; ?></td>
					</tr>
					<tr>
					   <td style="width:80%;"><?php echo $rw_cliente['telefono_cliente']; ?></td>
			        </tr>
					<tr>
					   <td style="width:80%;"><?php echo $rw_cliente['direccion_cliente']; ?></td>
			        </tr>
				</table>
			</td>
		</tr>
	</table>
<br><br>
        	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
			<tr>
				<td style="width:15%;">Fecha:</td>
				<td style="width:35%;"><?php echo date("d/m/Y", strtotime($fecha_factura));?></td>
				<td style="width:15%;">Nº Proforma:</td>
				<td style="width:35%;"><?php echo $numero_factura;?></td>
			</tr>
			<tr>
				<td style="width:15%;">C.I./RUC:</td>
				<td style="width:35%;"><?php echo $rw_cliente['cedula_cliente']; ?></td>
				<td style="width:15%;">Vigencia:</td>
				<td style="width:35%;">15 días</td>
			</tr>
			<tr>
				<td style="width:20%;">Condicion de pago:</td>
				<td style="width:30%;" >
					<?php 
					if ($condiciones==1){echo "Efectivo";}
					elseif ($condiciones==2){echo "Cheque";}
					elseif ($condiciones==3){echo "Transferencia bancaria";}
					elseif ($condiciones==4){echo "Crédito";}
					?>
			   </td>
			</tr>
	    	</table>

		    <br><br>
		    <table cellspacing="0" style="width: 90%; text-align: left; font-size: 10pt;">
		        <tr>
		            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
		            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
		            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
		            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
		            
		        </tr>

		<?php
		$nums=1;
		$sumador_total=0;$sumador_sinIVA=0;
		$sql=mysqli_query($con, "select * from products, detalle_proforma, proformas where products.id_producto=detalle_proforma.id_producto and detalle_proforma.numero_proforma=proformas.numero_proforma and proformas.id_proforma='".$id_proforma."'");

		while ($row=mysqli_fetch_array($sql))
			{
			$id_producto=$row["id_producto"];
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
			if($iva_producto!=0){
						$sumador_total+=$precio_total_r;//Sumador
					}else{
						$sumador_sinIVA+=$precio_total_r;//Sumador
					}
			if ($nums%2==0){
				$clase="clouds";
			} else {
				$clase="silver";
			}
			?>

		        <tr>
		            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
		            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php if($iva_producto!=1){ echo $nombre_producto;}else{echo "* ".$nombre_producto;}?></td>
		            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda;?><?php echo $precio_venta_f;?></td>
		            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda;?><?php echo $precio_total_f;?></td>
		            
		        </tr>

			<?php 

			
			$nums++;
			}
			$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
			$subtotal_general=number_format($sumador_total+$sumador_sinIVA,2,'.','');
			$subtotal=number_format($sumador_total,2,'.','');
			$total_iva=($subtotal * $impuesto )/100;
			$total_iva=number_format($total_iva,2,'.','');
			$total_factura=$subtotal+$total_iva+$sumador_sinIVA;
		?>
		        <tr>
		            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL <?php echo $simbolo_moneda;?> </td>
		            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal_general,2);?></td>
		        </tr>
		        <tr>
		            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL 0% <?php echo $simbolo_moneda;?> </td>
		            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($sumador_sinIVA,2);?></td>
		        </tr>
		        <tr>
		            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL 12% <?php echo $simbolo_moneda;?> </td>
		            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
		        </tr>
				<tr>
		            <td colspan="3" style="widtd: 85%; text-align: right;">IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?> </td>
		            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
		        </tr><tr>
		            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $simbolo_moneda;?> </td>
		            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
		        </tr>
		    </table>

		    <br><br>
		    <span style="color: #34495e;font-size:14px;font-weight:bold"><h5 align="center"> Gracias por su confianza</h5></span>

</page>